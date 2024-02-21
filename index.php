<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
    #map {
        height: 100%;
        width: 100%;
       }
.header {
  background: white;
  color: #215787;  /* duke color */
  font-size: 27px;
  padding: 0;
  font: Roboto;
  font-weight: 300;
}
.v1{
    display: inline-block;
    border-left: 1px solid #ccc;
    margin: 0 10px;
    height: 40px;
}
.v2{
    display: inline-block;
    border-left: 1px solid white;
    margin: 0 10px;
    height: 50px;
}
</style>
  <script>
    function initMap() {
      var mapProp= {
        center:new google.maps.LatLng(28.694478, -81.747921),
        zoom:7,
      };
      var map = new google.maps.Map(document.getElementById("map"),mapProp);
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
<div class="header">
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE ONE Light and Pole Status
 </div>
<div class="topnav" style="font-size:22px">
<ul> <li> <a>
    <form action="polesearch.php" method="get"> <label style="color:white">Enter exact or nearby Pole#: </label>
      <input type="text" name="poleid" size=20 />
      <input type="submit" value="Search Pole" />
    </form>
</a> </li>
<div class="topnav-right">
  <li><a class="active" href="./index.php">Home</a></li>
<!--    <li><a href="../login.php">Login</a></li> Remove login button as Tony request -->
<li><a target="popup" onclick="window.open('', 'popup', 'width=580,height=360,scrollbars=no, toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10')" href="sendMail.php">Contact</a></li>
</div>
</ul>
    
<div id="map" style="width:100%; height:740px"></div>
</body>
</html>
