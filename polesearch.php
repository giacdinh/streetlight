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
        var infoWindow = new google.maps.InfoWindow();
        
        var mapOptions = {
	  mapTypeId: google.maps.MapTypeId.roadmap
        } 
 
        var map = new google.maps.Map(document.getElementById('map'),mapOptions);
        var bounds = new google.maps.LatLngBounds();

        // Retrieve data from database
        <?php
            $spole = $_GET['poleid'];
            $squery = mysqli_query($con,"select groupname from sub_light where poleid = '$spole'");
	    $rowcnt = mysqli_num_rows($squery);
	    if($rowcnt == 0) {
		    echo ("addMarker(0, 0,'There is no match for \"$spole\". Click to return home','N/A','N/A','N/A',0,'N/A',0);\n");
	    }
	    else if ($rowcnt > 1)
	    {
	        //There are more than 1 subdivision, display all so customer can select
            	while ($sdata = mysqli_fetch_array($squery)) {
                    $group = $sdata['groupname'];
	            $gquery = mysqli_query($con,"select * from groups_light where groupname='$group'");
            	    $data = mysqli_fetch_array($gquery);
                    $groupname = $data['groupname'];
                    $grouplink = $data['grouplink'];
                    $gpsx = $data['gpsx'];
                    $gpsy = $data['gpsy'];
                    $desc = $data['description'];
                    $lightcnt = $data['lightcnt'];
                    echo ("addgroupMarker($gpsx, $gpsy, '$groupname','$grouplink','$desc',$lightcnt,'$spole');\n");
		}
            }
	    else {
            	while ($sdata = mysqli_fetch_array($squery))
                	$group = $sdata['groupname'];
	
            	$query = mysqli_query($con,"select * from sub_light where groupname = '$group'");
            	while ($data = mysqli_fetch_array($query))
            	{
                	$groupname = $data['groupname'];
               	 	$poleid = $data['poleid'];
                	$gpsx = $data['gpsx'];
                	$gpsy = $data['gpsy'];
                	$ptype = $data['ptype'];
                	$pname = $data['pname'];
                	$pheight = $data['pheight'];
                	$bulbtype = $data['bulbtype'];
                	$report = $data['rport_time'];
                
                	echo ("addMarker($gpsx, $gpsy,'$poleid','$groupname','$ptype','$pname',$pheight,'$bulbtype',$report);\n");
            	}
	    }
          ?>
          
        // Proses of making marker 
        function addMarker(gpsx,gpsy,poleid,groupname,ptype,pname,pheight,bulbtype,report) {
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
                    text: poleid, 
                    color: '#215787',
		    fontWeight: "bold",
                    fontSize: "16px",
                }
            });       
            map.fitBounds(bounds);
	    if(gpsx != 0 || gpsy != 0)
	    	bindInfoWindow(marker, map, infoWindow, gpsx,gpsy,poleid,ptype,pname,pheight,bulbtype,groupname,report);
	    else
		returntohomepage(marker);
         }
	function returntohomepage(marker) {
	    google.maps.event.addListener(marker, 'click', function() {
       		window.location.replace("https://de1fl.com");
	    });
	} 
        // Displays information on markers that are clicked
        function bindInfoWindow(marker, map, infoWindow, gpsx,gpsy,poleid,ptype,pname,pheight,bulbtype,groupname,report) {
          google.maps.event.addListener(marker, 'click', function() {
          if (report) {
	    const submitstr = 'Pole#: '+poleid+'<br><font style="color:red;">REPAIR IN PROGRESS' ; 
            map.panTo(marker.getPosition());
            map.setZoom(21);
	    //infoWindow.setTitle("Repair In Progress");
	    infoWindow.setContent(submitstr);
            infoWindow.open(map, marker);
            isServiceReport(infoWindow, poleid,groupname);
          } else {
	    const submitstr = 
		'<form method="get">' +
		'Pole#: '+poleid+'<br>'+
                '<select name="issue" id="issue">' +
                '<option value="">Select ...</option>' +
                '<option value="Light out">Light out</option>' +
                '<option value="Light flickering">Light flickering</option>' +
                '<option value="Light on all day">Light on all day</option>' +
                '<option value="Pole down">Pole down</option>' +
                '<option value="Pole down">Pole damage</option>' +
                "</select> <br>" +
                'Phone or email <br>' +
                '<input type="text" name="cinfo" id="cinfo" placeholder="required" required/><br>' +
                'Note<br>' +
                '<input type="text" name="note" id="note"/><br>' +
                '<input type="button" id="ReportBtn" value="Submit"/> </form>';
            map.panTo(marker.getPosition());
            map.setZoom(21);
	    infoWindow.setContent(submitstr);
            infoWindow.open(map, marker);
            isServiceReport(infoWindow, poleid,groupname);
          }
          });
	}
        function isServiceReport(infoWindow, poleid,groupname) {
            google.maps.event.addListener(infoWindow,'domready', function() {
                $('#ReportBtn').on('click', function () {
		    const option=document.getElementById("issue").value;
		    const contact=document.getElementById("cinfo").value;
		    const note=document.getElementById("note").value;
                    $.ajax({
                        type: "POST",
                        url: "save_pole_report.php?name="+poleid+"&report="+option+"&contact="+contact+"&group="+groupname+"&note="+note,
                        success: function(){
                        }
                    });
                    infoWindow.setContent('Pole#:'+poleid +' Thank you for report '+option)
                });
            });
        } 
	///////////////////////////////////////  FOR GROUP USE ///////////////////////////////////////////
        // Add groups marker as pole collided 
        function addgroupMarker(gpsx,gpsy,groupname,grouplink,desc,lightcnt,pole) {
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
            bindgroupInfoWindow(marker, map, infoWindow, groupname,pole);
         }

        // Displays information on markers that are clicked
        function bindgroupInfoWindow(marker, map, infoWindow, groupname,pole) {
          google.maps.event.addListener(marker, 'click', function() {
                //window.location.href = 'group.php?group='+groupname;
                window.location.href = 'polesearchgroup.php?group='+groupname+'&poleid='+pole;
                window.open(this.url, '_self');
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
<link rel="stylesheet" href="main.css">
<div class="header">
    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>
    <span class="v1"></span><font face="Roboto">Street & Area Light Repair
 </div>

<div class="topnav" style="font-size:25px">
<ul>
  <li><a style="color:white;">
        <?php
            $spole = $_GET['poleid'];
            $squery = mysqli_query($con,"select groupname from sub_light where poleid = '$spole'");
	    $rowcnt = mysqli_num_rows($squery);
	    if($rowcnt > 1) {
	        echo 'Select Subdivsion with pole issue'; 
	    }
	    else {
                while ($sdata = mysqli_fetch_array($squery)) { 
                    $group = $sdata['groupname'];
		    echo $group; 
		}
		echo '<li><a > Select Light Pole location on map to report issue</a></li>';
	    }
	?>
  </a></li>
  <div class="topnav-right">
  <li><a class="active" href="./index.php">Home</a></li>
    <li><a href="../login.php">Login</a></li>
    <li><a target="popup" onclick="window.open('', 'popup', 'width=580,height=360,scrollbars=no, toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10')" href="sendMail.php">Contact</a></li>
  </div>
</ul>
    
<div id="map" style="width:100%; height:740px"></div>
</body>
</html>
