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
        
    var marker;
      function initMap() {
        var infoWindow = new google.maps.InfoWindow;
        
        var mapOptions = {
	mapTypeId: google.maps.MapTypeId.roadmap 
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
                icon: { url: "./img/pole1.png",
                        labelOrigin: new google.maps.Point(10, 40),
                        size: new google.maps.Size(32,32),
                        anchor: new google.maps.Point(16,32)
                },
                label: {
                    text: groupname,
                    color: '#215787',
                    fontWeight: "bold",
                    fontSize: "16px"
                }
            });       
            map.fitBounds(bounds);
	    bindInfoWindow(marker, map, infoWindow, groupname);
         }
        
        // Displays information on markers that are clicked
        function bindInfoWindow(marker, map, infoWindow, groupname) {
          google.maps.event.addListener(marker, 'click', function() {
		window.location.href = 'group.php?group='+groupname;
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
<div class="header">
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE One Light and Pole Status
 </div>

<div class="topnav" style="font-size:20px">
<ul>
  <li><a href="./create_subdivision.php">Create Subdivision</a></li>
  <li><a href="./report.php">Reports</a></li>
  <li><a href="./history.php">History</a></li>
  <li><a>
	<form action="./subview.php" method="GET"> Subdivision Poles View
	<select name="subselect" id="subselect" style="font-size:15px">
	<option value="">Select ...</option>
	<?php
	    $group = mysqli_query($con,"select groupname from groups_light");
	    while($row = $group->fetch_assoc()) 
       	    {
         	echo '<option value="'.$row['groupname'].'">'.$row['groupname'].'</option>';
       	    }
        ?>
	<input type="submit" id="subview" value="Submit" style="font-size:15px"/>
	</select>
      </form></span></a></li>
  <div class="topnav-right">
  <li><a class="active" href="./index.php">Home</a></li>
  <li><a href="../logout.php">Logout</a></li>
  <li><a target="popup" onclick="window.open('', 'popup', 'width=580,height=360,scrollbars=no, toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10')" href="sendMail.php">Contact</a></li>

  </div>
</ul>
    
<div id="map" style="width:100%; height:800px"></div>
</body>
</html>
