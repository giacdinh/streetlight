<html language="en">
    <head>
<style>
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

    </head>
    <body>
<div class="header">
   <!-- a href="page"><img style="width:30px;" src=/img/burger.png></a> -->
    <span class="v2"></span><img style="width:100px;" src="/img/dukeone.svg">
    <span class="v1"></span><font face="Roboto">Street & Area Light Repair
 </div>
<link rel="stylesheet" href="main.css">
<div class="topnav" style="font-size:22px;text-align:center;">
<ul> <li> <a> Create Subdivision Group for Mobile device use only</a></li></ul></div>

<button type="default" class="btn btn-primary" style='font-size:50px' onclick="getLocation()">Get Subdivision GPS Coord</button>
<form action="./save_group_info.php" method="GET">
    <hr style='width:200%;text-align:left;margin-left:0'>
        <label for='latitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Latitude:</label>
            <input type='text' class='form-control' name='latitude' id='latitude' style='font-size:50px'>
<br>
        <label for='longitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Longitude:</label>
            <input type='text' class='form-control' name='longitude' id='longitude' style='font-size:50px'>
<br><br>
	<label for="groupname" style='font-size:50px'>Site Name:</label>
  	    <input type="text" id="groupname" name="groupname" style='font-size:50px'><br>
	<label for="description" style='font-size:50px'>Description:</label>
  	    <input type="text" id="description" name="description" style='font-size:50px'><br>
	<label for="polecnt" style='font-size:50px'>Pole count:</label>
  	    <input type="text" id="polecnt" name="polecnt" style='font-size:50px'><br>
    <br> <br>
    <input type="submit" value="Submit" style='font-size:75px'>
</form> 



<script type="text/javascript">
var x = document.getElementById("subdivision");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  document.getElementById("latitude").value = roundTo(position.coords.latitude, 6);
  document.getElementById("longitude").value = roundTo(position.coords.longitude,6);
}
function roundTo(n, digits) {
    var negative = false;
    if (digits === undefined) {
        digits = 0;
    }
    if (n < 0) {
        negative = true;
        n = n * -1;
    }
    var multiplicator = Math.pow(10, digits);
    n = parseFloat((n * multiplicator).toFixed(11));
    n = (Math.round(n) / multiplicator).toFixed(digits);
    if (negative) {
        n = (n * -1).toFixed(digits);
    }
    return n;
}
</script>

</body>
</html>
