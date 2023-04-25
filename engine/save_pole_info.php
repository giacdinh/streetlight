<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
//get database config information
    $json = file_get_contents('./backend.json');
    $json_data = json_decode($json,true);
    $server    = $json_data["servername"];
    $database  = $json_data["database"];
    $username  = $json_data["username"];
    $password  = $json_data["password"];
    $miss = "";
    $lat = $_GET["latitude"];
    $long = $_GET["longitude"];
    $groups = $_GET["groupname"];
    if(!$groups)
	$miss = $miss." Group/Subdivision";
    $poleid= $_GET["poleid"];
    if(!$poleid)
	$miss = $miss." PoleID";
    $poletype = $_GET["poletype"];
    $poleheight = $_GET["poleheight"];
    $polename = $_GET["polename"];
    $bulb = $_GET["bulb"];

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn) {
	echo "DBase connect failed";
	die("Connection failed: " . mysqli_connect_error());
	echo "DBase connect failed";
}

$qstring = "INSERT INTO sub_light (groupname,poleid,gpsx,gpsy,ptype,pname,pheight,bulbtype,report,rport_time,cust_resp,resp_time) VALUES (\"$groups\",\"$poleid\",$lat,$long,\"$poletype\",\"$polename\",$poleheight,\"$bulb\",\"NA\",0,\"NA\",0)";
echo "<br>$qstring <br>";
$result = mysqli_query($conn, $qstring);
if(!$result) {
	echo "<div style='font-size:75px ;color:red'>DBase insert failed.<br> No Pole was inserted.<br> Missing: $miss.</div>";
	die("DBase insert failed: " . mysqli_query_error());
}
echo "<div style='font-size:75px ;color:green'>Insert pole information successed</div>";

$conn->close();
?>
