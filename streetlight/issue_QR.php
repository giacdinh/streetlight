<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>

<h1 style='font-size:55px; color:MediumAquamarine; text-align:center'> BAC SON Technologies <br> Street Light issue </h1>

<button type="default" class="btn btn-primary" style='font-size:50px' onclick="getLocation()">Get Pole GPS Coord</button>
<form action="./save_pole_issue.php" method="GET">
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
<br>
	<label for="poleid" style='font-size:50px'>Pole ID:</label>
  	    <input type="text" id="poleid" name="poleid" style='font-size:50px'><br>
<br>
        <label for='poleissue' class='col-md-4 col-form-label text-md-right' style='font-size:50px'>Issue:</label>
        <select class='form-control' name='poleissue' style='font-size:50px' id="poleissue">
            <option value='Light out'>Light out</option>
            <option value='Light flickering'>Light flickering</option>
            <option value='Light on all day'>Light on all day</option>
            <option value='Pole lean'>Pole lean</option>
            <option value='Pole damage'>Pole damage</option>
            <option value='Other'>Other ...</option>
        </select>
  	<br>
	<label class='col-md-4 col-form-label text-md-right' style='font-size:50px'>
	Leave phone or email <br>
	If you want notifying after issue fix <br> 
	<input type="text" name="cinfo" id="cinfo" style='font-size:50px'/><br> </label>
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
