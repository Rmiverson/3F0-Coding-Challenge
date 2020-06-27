<html lang="en">
  <head>
      <?php
        require '../testing/vendor/autoload.php';
        use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
        use Geocoder\Query\GeocodeQuery;
        use Geocoder\Query\ReverseQuery;
          
        $adapter = new GuzzleAdapter();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($adapter, null, 'AIzaSyCLq1iwqcH4A7juGiCvVHNeGlNOGllqDKI');
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en'); 
        
        $load = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["address"])){
            $load = false;
          } else {
            $load = true;
            $geoAddress = $_POST["address"];
            $results = $geocoder->geocodeQuery(GeocodeQuery::create("$geoAddress"));
            $coords = $results->first()->getCoordinates();
            $px = json_encode($coords->getLatitude());
            $py = json_encode($coords->getLongitude());

            ?>
            <script>
              let map;
              let px;
              let py;
              function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                  center: { lat: <?php echo $px; ?>, lng: <?php echo $py; ?>},
                  zoom: 8
                });
              }
            </script>
            <?php
          }
        }
      ?>
      
      <title>Geocoding challenge</title>
      <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBzfCI-lJhHEipPBGzYmy4Mbk7mDkCBaA&callback=initMap&libraries=&v=weekly"></script>

      <link rel="stylesheet" type="text/css" href="./styles.css" />
  </head>
  <body>
    <header>
      <h1>Site Title</h1>
    </header>

    <div class="sub-title">
      <h3>Sub-Title</h3>
    </div>
    
    <div id="body-content">
      <div class="content-box">
        <h3>Content Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel lorem eu libero tincidunt interdum et et lacus. Maecenas in nisi scelerisque libero molestie suscipit ac quis odio. Nam gravida, erat dapibus viverra feugiat, tortor odio tincidunt nibh, sit amet egestas felis lectus ac magna. Aenean nec turpis in lectus mollis bibendum ac eget quam. In imperdiet consequat felis sed finibus. Phasellus aliquam pellentesque vestibulum. Donec rutrum efficitur urna, et congue felis lobortis vitae. Cras eu ante sed eros dictum mattis. Morbi ultricies quam vitae tristique viverra. Donec eget pretium neque. Nam hendrerit leo quis rutrum feugiat.</p>
      </div>

      <div class="content-box">
        <h3>Content Title</h3>
        <p>Sed convallis enim ut ante ultricies, tempor viverra augue iaculis. Pellentesque lorem ex, pulvinar in laoreet quis, volutpat id augue. Maecenas id sodales lacus. Ut eu pretium sapien. Donec eleifend efficitur magna non lacinia. In lobortis risus non enim lobortis, pretium pharetra ipsum posuere. Quisque ut ultrices purus, eget tempus purus. Nulla pulvinar neque non purus vestibulum viverra quis sit amet arcu. Vestibulum non nisl non sem rhoncus pretium id eget lacus. Aenean ultrices feugiat ipsum. Donec facilisis diam non odio molestie molestie. Sed viverra lacus mi, nec pellentesque erat volutpat eu.</p>
      </div>
    </div>

    <div class="sub-title">
      <h3>Sub-Title</h3>
    </div>   

    <div id="form-content">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        Address: <input type="search" name="address" ><br>
        <input id="myBtn" type="submit">
      </form>
    </div>
 
    <div id='myModal' class='modal <?php if ($load == true) {echo "on";}?>'> 
      <div class='modal-content'>
        <span class='close'>&times;</span>
        <div id='map'></div>
      </div>
    </div>
    
    <script src="scripts.js"></script>
  </body>
</html>