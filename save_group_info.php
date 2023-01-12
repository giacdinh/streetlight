<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
$now = time();
//get database config information
    $json = file_get_contents('./backend.json');
    $json_data = json_decode($json,true);
    $server    = $json_data["servername"];
    $database  = $json_data["database"];
    $username  = $json_data["username"];
    $password  = $json_data["password"];
    $missing = "";
    $lat = $_GET["latitude"];
    $long = $_GET["longitude"];
    $groups = $_GET["groupname"];
    $description = $_GET["description"];
    if(!$description) {
	$missing = $missing." description";
	$description = "N/A";
    }
    $polecnt = $_GET["polecnt"];
    if(!$polecnt) {
	$missing = $missing." polecount";
	$polecnt = 0;
    }
$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn) {
	echo "DBase connect failed";
	die("Connection failed: " . mysqli_connect_error());
	echo "DBase connect failed";
}

$qstring = "INSERT INTO groups_light (groupname,gpsx,gpsy,description,lightcnt,c_time) VALUES (\"$groups\",$lat,$long,\"$description\",$polecnt,$now)";
echo "<br>$qstring <br>";
$result = mysqli_query($conn, $qstring);
if(!$result) {
    echo "<div style='font-size:75px ;color:red'>DBase insert failed.<br> Missing: $missing.<br>";
    die("DBase insert failed: " . mysqli_query_error());
}
echo "<div style='font-size:75px ;color:green'>Insert pole information successed. Missing: $missing</div>";

$conn->close();
?>
