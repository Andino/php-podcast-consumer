<?php 
/**
 * Made By: Diego Andino - Andinod on gitlba https://gitlab.com/Andinod - Andino on github https://github.com/Andino
 * Technologies: PHP, JS with Ecmascript, Animatecss, TailwindCSS, Bootstrap
 */
$default_rss = "https://feeds.megaphone.fm/offthechain";
$rss_feed = simplexml_load_file($default_rss);
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PHP Test</title>
  <meta name="description" content="A simple php test for podcasts.">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" 
   integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script type="text/javascript" src="fetch.js"></script>
</head>

<body>
    <div class="flex items-center justify-center mt-10">
        <form class="row flex justify-center">
            <div class="col-md-12 text-center">
                <input type="text" readonly 
                class="font-bold text-center uppercase form-control-plaintext" 
                id="staticEmail2" 
                value="Enter your podcast URI">
                <small class="font-bold">
                    Default podcast: 
                    <small class="font-lighter"> 
                        <?php echo $default_rss?>
                    </small>
                </small>
                <small class="font-bold">
                    Disclaimer: 
                    <small class="font-lighter"> 
                        If the provided date range doesn't found any podcast, 
                        the process will fetch the latest podcasts!
                    </small>
                </small>
                <br>
            </div>
            <div class="col-auto mt-3">
                <label for="uriinput" class="visually-hidden">Uri</label>
                <input type="text" class="form-control" id="uriinput" 
                placeholder="For example https://feeds.feedburner.com/ltb/BAG">
            </div>
            <div class="col-auto mt-3">
                <label for="date" class="visually-hidden">date</label>
                <input id="date-range" class="border-2 p-1 border-gray-300 rounded-md" 
                type="text" name="daterange" value="09/09/2021 - 09/15/2021" />
            </div>

            <div class="col-auto mt-3">
                <button onClick="fetchURI()" type="button" 
                class="btn btn-primary mb-3 flex items-center justify-center">
                    Fetch Podcasts
                <div id="spinnerLoading" class="spinner-border ml-2 h-5 w-5" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </button>
            </div>
        </form>
    </div>
    <div id="fetched-data" class="w-full flex flex-wrap justify-between items-center m-2">
      <?php
        if (!empty($rss_feed)) {
            $i = 0;
            foreach ($rss_feed->channel->item as $feed_item) {
                if ($i >= 10) {
                    break;
                }
                ?>
                <div class="animate__animated animate__fadeInUp card mt-5" style="width: 18rem;">
                <?php foreach ($rss_feed->channel->image as $feed_image) {
                    $image = (string) $feed_image->url;?>
                    <img src='<?= $image ?>' class='card-img-top' alt='<?= $feed_image->title?>'>
                <?php } ?>
                <div class="card-body h-64 overflow-y-auto flex flex-wrap items-center justify-center">
                    <audio class="w-full" controls>
                        <source src="<?= $feed_item->enclosure['url']?>" type="audio/ogg">
                        <source src="<?= $feed_item->enclosure['url']?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <h5 class="card-title mt-2 font-bold"><?=$feed_item->title?></h5>
                    <h5 class="small"><?=$feed_item->pubDate?></h5>
                    <p class="card-text"><?=$feed_item->description?></p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
                </div>
                <?php $i++;
            }
        }?>
      ?>
    </div>
</body>
</html>
<script>
$("#spinnerLoading").hide();
</script>