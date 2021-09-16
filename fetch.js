$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});

function fetchURI(){
    $("#spinnerLoading").show();
    const uri_value = $("#uriinput").val()
    const cors_validator = "https://cors-anywhere.herokuapp.com/"; 
    let dates = $("#date-range").val();
    dates = dates.split(" -");
    if(uri_value){
        fetch(`${cors_validator}${uri_value}`)
        .then(response => response.text())
        .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
        .then(data => {
            let html = ``;
            let html_outside = ``;
            let image = ``;
            let image_title = ``;
            let url = ``;
            $(data).find("image").each(function () { // or "item" or whatever suits your feed
                var el = $(this);
                image = el.find("url").text();
                image_title = el.find("title").text();
            });
            
            $(data).find("item").each(function () { // or "item" or whatever suits your feed
                var el = $(this);
                $(el).find("enclosure").each(function() { 
                    var item = $.parseHTML($(this)[0].outerHTML);
                    url = $(item).attr('url');
                });
                const pubDate = el.find("pubDate").text();
                const date = new Date(pubDate);
                const minDate = new Date(dates[0]);
                const maxDate = new Date(dates[1]);
                const isBetween = date >= minDate && date <= maxDate;
                if(isBetween){
                    html += `
                        <div class="animate__animated animate__fadeInUp card mt-5" style="width: 18rem;">
                        <img src="${image}" class="card-img-top" alt="${image_title}">
                        <div class="card-body h-64 overflow-y-auto flex flex-wrap items-center justify-center">
                            <audio class="w-full" controls>
                                <source src="${url}" type="audio/ogg">
                                <source src="${url}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <h5 class="card-title mt-2 font-bold">${el.find("title").text()}</h5>
                            <h5 class="small">${el.find("pubDate").text()}</h5>
                            <p class="card-text">${el.find("description").text()}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                        </div>
                    `;
                }
                else{
                    html_outside += `
                        <div class="animate__animated animate__fadeInUp card mt-5" style="width: 18rem;">
                        <img src="${image}" class="card-img-top" alt="${image_title}">
                        <div class="card-body h-64 overflow-y-auto flex flex-wrap items-center justify-center">
                            <audio class="w-full" controls>
                                <source src="${url}" type="audio/ogg">
                                <source src="${url}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <h5 class="card-title mt-2 font-bold">${el.find("title").text()}</h5>
                            <h5 class="small">${el.find("pubDate").text()}</h5>
                            <p class="card-text">${el.find("description").text()}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                        </div>
                    `;
                }
            });
            $("#fetched-data").fadeOut();
            $("#fetched-data").empty();
            $("#fetched-data").fadeIn();
            var container = document.getElementById('fetched-data');
            if(html.length < 1){
                container.insertAdjacentHTML("beforeend", html_outside);
            } else { 
                container.insertAdjacentHTML("beforeend", html);
            }
            $("#spinnerLoading").fadeOut();
        });
    }
}