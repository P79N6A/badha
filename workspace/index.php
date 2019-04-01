<!DOCTYPE html>
<?php include 'get.php';?>

<html>
  <head>
    <title>Badha - Avoid the obstructions</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="manifest" href="/manifest.json">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/markercluster.js"></script>
    <div id="dom-target" style="display: none;">
    <?php 
       //Again, do some operation, get the output.
        echo htmlspecialchars($cod); /* You have to escape because the result
                                           will not be valid HTML otherwise. */
    ?></div>

    <script>
      
      
          // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var gpsx;

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 27.7089603, lng: 85.32613284},
          zoom: 16
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            //For submitting current location
            document.getElementsByName("lat")[0].setAttribute("value",pos.lat);            
            document.getElementsByName("long")[0].setAttribute("value",pos.lng);
            var image = "https://i.stack.imgur.com/PYAIJ.png";
            //Your position marker
            var beachMarker = new google.maps.Marker({
              position: pos,
              map: map,
              icon: image,
              label: "YOU"
            });
            map.setCenter(pos);
        
        //Retreiving lats and longs of obstructions from php
        var mainarray = <?php echo json_encode($cod, JSON_HEX_TAG);?>;

        console.log(mainarray);
        
        //Placing markers for each row of db
        for (i = 0; i < mainarray.length; i++) { 
            var setx = (mainarray[i]);
            
            var setarray = setx.split(',');
            
            var mapase_status = setarray[2];
            var license_status = setarray[3];
            var general_status = setarray[4];
            
            //alert(setarray[0]);  //Lat
            //alert(setarray[1]);  //Long
            
            var mapase_icon = "/src/mapase.png";
            var general_icon = "/src/general.png";
            var license_icon = "/src/license.png";
            
            
            //var xlocation = {lat:parseFloat(setarray[0]), lng: parseFloat(setarray[1])};
            var status_array = [];
            if(mapase_status){
                status_array.push(mapase_icon)
              }
            if(general_status){
                status_array.push(general_icon)
              }
            if(license_status){
                status_array.push(license_icon)
              }
            //console.log(status_array); Status_array is the collection of images to shown for traffoc status
            for (status in status_array){
              //console.log(status);
              var foffset = status/100000;
              console.log(foffset);
              var latitude = parseFloat(setarray[0]);// + parseFloat(foffset);
              console.log("Lat:",latitude);
              var longitude = parseFloat(setarray[1]) + parseFloat(foffset);
              console.log("Long:",longitude);
              
              var xlocation = {lat:latitude, lng:longitude};
              var geolocation = new google.maps.Marker({
              position: xlocation,
              map: map,

            
              icon: {
              url: status_array[status],
              //size: new google.maps.Size(36, 36),
              
              anchor: new google.maps.Point(18, 18),
              scaledSize: new google.maps.Size(25, 25)
              }
              
              //icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
             });
            }
            
        }  
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
        
      }


      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
    
    </script>
    
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD--wUS6DHsTXXxNoU1-JKym8_Ur1iMHp4&callback=initMap">
    </script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 90.5%;
        margin: 0;
        padding: 0;
        font-size: 1.050em;
      }
      
    </style>
  </head>
  
  <body>
    <div id="map"></div>
    
    
    
    
    <br/>
    
    <form action="/put.php">
        <input name="lat" type="hidden">  
        <input name="long" type="hidden">   
        <center>
        <input type="checkbox" name="m" value="yes">  Mapase 
        <input type="checkbox" name="l" value="yes">  Licence Check 
        <input type="checkbox" name="g" value="yes">  General 
    <br/>
    <br/>
    
    <button type="submit" value="Mark">Here</button>
        </center>
    </form>
  </body>
</html>