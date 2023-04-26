<html language="en">
    <head>
    </head>
    <body>

<h1 style='font-size:55px; color:MediumAquamarine; text-align:center'> BAC SON Technologies <br> Create Subdivision Group </h1>

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
