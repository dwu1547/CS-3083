<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50%;
		width:50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  input.inp{
	width:20%;
	
}
input.din {
    line-height: 100px;
	width:30%;
}
    </style>
	<script type="text/javascript" src="jsEvents.js"></script>
  </head>
  <body>
  <div id="floating-panel">
      <input id="address" type="textbox" placeholder="Location Name,Street,City">
      <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map"></div>
    <script>
      var map;
	  var myLatLng = {lat: 40.363, lng: -73.044};
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 40.6782, lng: -73.9422},
          zoom: 8
        });
		
        google.maps.event.addListener(map,'click',function(event) {
          document.getElementById('Lat').value = event.latLng.lat()
          document.getElementById('Lng').value = event.latLng.lng()
		  document.getElementById("latlng").value = event.latLng.lat()+","+event.latLng.lng();
        });
		 var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
		 document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
		  
        });
		
      }
	  
	  function geocodeLatLng(geocoder, map, infowindow) {
        var inputLat = document.getElementById('Lat').value;
		var inputLong =document.getElementById('Lng').value;
        var latlng = {lat: parseFloat(inputLat), lng: parseFloat(inputLong)};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[1]) {
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[1].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
	
	  function updateLoc(){
	  document.getElementById('address').value = document.getElementById('LName').value+','+document.getElementById('Street').value+','+document.getElementById('City').value+","+document.getElementById("Zip").value;
	 }
	  function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			 document.getElementById('Lat').value = latitude;
          document.getElementById('Lng').value = longitude;
		  
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
		
		 
			
	
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCT1GVFMs6VUuEqfTiT9IHelucIxidZRoA&callback=initMap"
    async defer></script>
	<br>
	<form action="insertLoc.php" method="get">
	<span>Location Name:</span><input class="inn" id="LName" name="Locname" maxlength="20" onkeyup="updateLoc()">
	<span>Street:<span><input class="inn" id="Street" name="Stname" maxlength="50" onkeyup="updateLoc()">
	<span>City:</span><input class="inn" id="City" name="Ctname" maxlength="20" onkeyup="updateLoc()">
	<br>
	<br>
	<span>Zip:</span><input class="inn" type="text" name="Zname" id="Zip" value="00000" maxlength="5" onkeyup="updateLoc()" onkeypress="return isNumberKey(event)">
	<span>Latitude:</span><input class="inn" name="Latname" maxlength="50" id="Lat">
	<span>Longitude:</span><input class="inn" name="Lngname" maxlength="50" id="Lng">
	<br>
	<br>
	<!-- <span>Description:</span><input type="text" class="din" name="Desc" id="Descript">  -->
  <label for="Desc"> Description: </label>
  <textarea name="Desc" class="din" id="Descript" rows="10" cols="40"></textarea>
		<br>
	     <input type="submit">
        <input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
	<br>
	</form>
  </body>
</html>