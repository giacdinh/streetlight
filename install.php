<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
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
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE One Light and Pole Status
 </div>
<link rel="stylesheet" href="main.css">
<div class="topnav" style="font-size:22px;text-align:center;">
<ul> <li> <a> Scan Pole GPS for Mobile device use only</a></li></ul></div>

<button type="default" class="btn btn-primary" style='font-size:50px' onclick="getLocation()">Get Pole GPS Coord</button>
<form action="./save_pole_info.php" method="GET">
    <hr style='width:200%;text-align:left;margin-left:0'>
        <label for='latitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Latitude:</label>
            <input type='text' class='form-control' name='latitude' id='latitude' style='font-size:50px' readonly>
<br>
        <label for='longitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Longitude:</label>
            <input type='text' class='form-control' name='longitude' id='longitude' style='font-size:50px' readonly>
<br><br>
<label for="groupname" class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Group ID:</label>
	<select class='form-control' name='groupname' style='font-size:50px' id="groupname">
	<?php
	   $query = mysqli_query($con,"select groupname from `groups_light`");
            while ($data = mysqli_fetch_array($query)):;
        ?>
        <option value="<?php echo $data["groupname"]; ?>"><?php echo $data["groupname"]; ?></option>
        <?php
            endwhile;
        ?>
        </select>
<br><br>
	<label for="poleid" style='font-size:50px'>Pole ID:</label>
  	    <input type="text" id="poleid" name="poleid" style='font-size:50px'><br>
<br><br>
        <label for='poletype' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Pole Type:</label>
        <select class='form-control' name='poletype' style='font-size:50px' id="poletype">
            <option value='Aluminium'>Aluminium</option>
            <option value='Metal'>Metal</option>
            <option value='Concrete'>Concrete</option>
            <option value='Fiberglass'>Fiberglass</option>
            <option value='Wood'>Wood</option>
        </select>
  	<br>
        <label for='latitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Pole Height:</label>
        <select class='form-control' name='poleheight' style='font-size:50px' id="poleheight">
            <option value='12'>12ft</option>
            <option value='15'>15ft</option>
            <option value='20'>20ft</option>
            <option value='25'>25ft</option>
            <option value='30'>30ft</option>
            <option value='30'>40ft</option>
        </select>
  	<br>
        <label for='latitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Light Globe:</label>
        <select class='form-control' name='polename' style='font-size:50px' id="polename">
            <option value='Traditional'>Traditional</option>
            <option value='Town and Country'>Town and Country</option>
            <option value='Monticello'>Monticello</option>
            <option value='Enterprise'>Enterprise</option>
        </select>
  	<br>
        <label for='latitude' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Light Type:</label>
        <select class='form-control' name='bulb' style='font-size:50px' id="bulb">
            <option value='LED'>LED</option>
            <option value='HPS'>HPS</option>
        </select>
    <br> <br>
    <input type="submit" value="Submit" style='font-size:75px'>
</form> 



<script type="text/javascript">
var x = document.getElementById("demo");

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
