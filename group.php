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
        var infoWindow = new google.maps.InfoWindow();
        
        var mapOptions = {
	mapTypeId: google.maps.MapTypeId.HYBRID 
        } 
 
        var map = new google.maps.Map(document.getElementById('map'),mapOptions);
        var bounds = new google.maps.LatLngBounds();

        // Retrieve data from database
        <?php
	    $group = $_GET['group'];
            $query = mysqli_query($con,"select * from sub_light where groupname = '$group'");
            while ($data = mysqli_fetch_array($query))
            {
                $groupname = $data['groupname'];
                $poleid = $data['poleid'];
                $gpsx = $data['gpsx'];
                $gpsy = $data['gpsy'];
                $ptype = $data['ptype'];
                $pheight = $data['pheight'];
                $bulbtype = $data['bulbtype'];
                
                echo ("addMarker($gpsx, $gpsy,'$poleid','$groupname','$ptype',$pheight,'$bulbtype');\n");                        
            }
          ?>
          
        // Proses of making marker 
        function addMarker(gpsx,gpsy,poleid,groupname,ptype,pheight,bulbtype) {
            var location = new google.maps.LatLng(gpsx, gpsy);
            bounds.extend(location);
            var marker = new google.maps.Marker({
                map: map,
                position: location,
		icon: { url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" },
                label: {
                    text: poleid, 
                    color: 'white',
                    fontSize: "16px"
                }
            });       
            map.fitBounds(bounds);
	    bindInfoWindow(marker, map, infoWindow, gpsx,gpsy,poleid,ptype,pheight,bulbtype);
         }
        
        // Displays information on markers that are clicked
        function bindInfoWindow(marker, map, infoWindow, gpsx,gpsy,poleid,ptype,pheight,bulbtype) {
          google.maps.event.addListener(marker, 'click', function() {
	    const submitstr = 
		'<form method="get">' +
		'Poleid:'+poleid+'<br>'+
		'Ptype:'+ptype+' Pheight:'+pheight+' Bulb:'+bulbtype+'<br>' +
		'Coord:'+gpsx+','+gpsy+'<br>'+
                '<select name="myselect" id="myselect" onchange="this.form.submit()">' +
                '<option value="">Select ...</option>' +
                '<option value="Light out">Light out</option>' +
                '<option value="Light flickering">Light flickering</option>' +
                '<option value="Light on all day">Light on all day</option>' +
                '<option value="Pole down">Pole down</option>' +
                '<option value="Pole down">Pole damage</option>' +
                '<option value="Other">Other ...</option>' +
                "</select> <br><br>" +
                'Phone or email for after fixed update<br>' +
                '<input type="text" name="cinfo" id="cinfo"/><br><br>' +
                '<input type="button" id="ReportBtn" value="Submit"/> </form>';
            map.panTo(marker.getPosition());
            map.setZoom(22);
	    infoWindow.setContent(submitstr);
            infoWindow.open(map, marker);
            isServiceReport(infoWindow, poleid);
          });
	}
        function isServiceReport(infoWindow, poleid) {
            google.maps.event.addListener(infoWindow,'domready', function() {
                $('#ReportBtn').on('click', function () {
		    const option=document.getElementById("issue").value;
		    const contact=document.getElementById("cinfo").value;
                    $.ajax({
                        type: "POST",
                        url: "save_pole_report.php?name="+poleid+"&report="+option+"&contact="+contact,
                        success: function(){
                        }
                    });
                    infoWindow.setContent('Pole ID:'+poleid +' Thank you for report '+option)
                });
            });
        } 
    } 
    </script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy-rj-7eYIXR5Tb9xA5YjyTgNwng6LIaE&callback=initMap">
</script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>

</head>
<body onload="initMap()">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="demo.css">
<div class="topnav" style="font-size:25px">
<ul>
  <li><a class="active" href="./index.php">Home</a></li>
  <li><a href="./install.php">Pole Install</a></li>
  <div class="topnav-right">
    <li><span title="407-416-1064&#013;bacsonteam@hostinger.com"> <a href="#">Contact</a><span></li>
  </div>
</ul>
    
<div id="map" style="width:100%; height:800px"></div>
</body>
</html>
