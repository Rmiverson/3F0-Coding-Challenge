<!-- 300feetout coding challenge -->
<!-- using: composer installed locally, Guzzle 6 HTTP Adapter, Geocoder-PHP by willdurand, Google Maps Geocoder provider, and their dependencies -->
<html lang="en">
  <head>
      <?php
        // used by composer
        require 'vendor/autoload.php';
        // http adapter needed for google maps geocoder
        use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
        // takes an input in the form of a string and returns lat and long coordinates
        use Geocoder\Query\GeocodeQuery;
        // not needed, reverse query takes coordinates and returns a place
        use Geocoder\Query\ReverseQuery; 
          

        // setting initial variables for geocoding the coordinates
        $adapter = new GuzzleAdapter();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($adapter, null, '');
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en'); 
        
        
        // load is used to reference that the modal and map should not be loaded
        $load = false;
        // if the user presses the submit button on the form, this code will run
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // checks if the text field in the form is empty
          if (empty($_POST["address"])){
            // if it's empty then it leaves the load reference to false
            $load = false;
          } else {
            // if the user enters an address,then the geocoding sequence starts and load reference is true now
            $load = true;

            // gets the input from the form
            $geoAddress = $_POST["address"];
            // uses the user input string to geocode using geocoder variable
            $results = $geocoder->geocodeQuery(GeocodeQuery::create("$geoAddress"));
            // accesses the geocoded input for coordinates
            $coords = $results->first()->getCoordinates();
            // assigns geocoded coordinates to respective x and y values
            $px = json_encode($coords->getLatitude());
            $py = json_encode($coords->getLongitude());

            ?>
            <script>
              // switching to JS while still in the php if statement
              // declares variable to use 
              let map;
              let px;
              let py;

              // function uses the php variables with x and y coordinates to create a google map  
              function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                  center: { lat: <?php echo $px; ?>, lng: <?php echo $py; ?>},
                  zoom: 8
                });
              }
            </script>
            <?php
            // reentering php to finish if statements
          }
        }
      ?>
      
      <title>Geocoding challenge</title>
      <!-- scripts used are for google maps -->
      <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBzfCI-lJhHEipPBGzYmy4Mbk7mDkCBaA&callback=initMap&libraries=&v=weekly"></script>

      <!-- styles for page -->
      <link rel="stylesheet" type="text/css" href="./styles.css" />
  </head>
  <body>
    <header>
      <h1>Site Title</h1>
    </header>

    <div class="sub-title">
      <h3>Sub-Title</h3>
    </div>
    
    <!-- filler main content using flexbox -->
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

    <!-- form used to collect the input from user -->
    <div id="form-content">
      <!-- the form when submitted will give the information to itself instead of refering to a php file on the server -->
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        Address: <input type="search" name="address" ><br>
        <input id="myBtn" type="submit">
      </form>
    </div>
        
    <!-- the modal that is hidden by default as long as the php variable "load" is false -->
    <div id='myModal' class='modal <?php if ($load == true) {echo "on";}?>'> 
      <div class='modal-content'>
        <span class='close'>&times;</span>
        <div id='map'></div>
      </div>
    </div>
    
    <!-- scripts used to manage the modal -->
    <script src="scripts.js"></script>
  </body>
</html>
