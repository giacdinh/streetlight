<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
    #map {
        height: 100%;
        width: 100%;
       }
</style>
    <script>
        
    var marker;
      function initMap() {
        var infoWindow = new google.maps.InfoWindow;
        
        var mapOptions = {
	mapTypeId: google.maps.MapTypeId.HYBRID 
        } 
 
        var map = new google.maps.Map(document.getElementById('map'),mapOptions);
        var bounds = new google.maps.LatLngBounds();

        // Retrieve data from database
        <?php
            $query = mysqli_query($con,"select * from groups_light");
            while ($data = mysqli_fetch_array($query))
            {
                $groupname = $data['groupname'];
                $grouplink = $data['grouplink'];
                $gpsx = $data['gpsx'];
                $gpsy = $data['gpsy'];
                $desc = $data['description'];
                $lightcnt = $data['lightcnt'];
                
                echo ("addMarker($gpsx, $gpsy, '$groupname','$grouplink','$desc',$lightcnt);\n");                        
            }
          ?>
          
        // Proses of making marker 
        function addMarker(gpsx,gpsy,groupname,grouplink,desc,lightcnt) {
            var location = new google.maps.LatLng(gpsx, gpsy);
            bounds.extend(location);
            var marker = new google.maps.Marker({
                map: map,
                position: location,
                label: {
                    text: groupname,
                    color: 'white',
                    fontSize: "16px"
                }
            });       
            map.fitBounds(bounds);
	    bindInfoWindow(marker, map, infoWindow, groupname);
         }
        
        // Displays information on markers that are clicked
        function bindInfoWindow(marker, map, infoWindow, groupname) {
          google.maps.event.addListener(marker, 'click', function() {
		window.location.href = 'guestgroup.php?group='+groupname;
		window.open(this.url, '_self');
          });
	}
 
    }
    
    </script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy-rj-7eYIXR5Tb9xA5YjyTgNwng6LIaE&callback=initMap">
</script>
</head>
<body onload="initMap()">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="main.css">
<div class="topnav" style="font-size:20px">
<ul>
<li><a style="color:red;font-size:30px;">Select/Click your destination subdivision/site </a></li>
  <div class="topnav-right">
    <li><a href="../logout.php">Logout</a></li>
    <li><span title="407-416-1064&#013;bacsonteam@hostinger.com"> <a href="#">Contact</a><span></li>
  </div>
</ul>
    
<div id="map" style="width:100%; height:800px"></div>
</body>
</html>
