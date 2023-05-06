<html>
    <head>
    </head>
    <body>
    </body>
</html>

<?php
$poleid = $_GET['poleid'];
$now = time();
//get database config information
    $json = file_get_contents('./backend.json');
    $json_data = json_decode($json,true);
    $server    = $json_data["servername"];
    $database  = $json_data["database"];
    $username  = $json_data["username"];
    $password  = $json_data["password"];

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn) {
	echo "DBase connect failed";
	die("Connection failed: " . mysqli_connect_error());
	echo "DBase connect failed";
}
$qinsert = "INSERT INTO `pole_history` (groupname,poleid,report,rport_time,cust_resp,cust_note) SELECT groupname,poleid,report,rport_time,cust_resp,notes FROM `sub_light` where poleid = '$poleid' ";

echo $qinsert;
$result = mysqli_query($conn, $qinsert);
if(!$result) {
        echo "<div style='font-size:25px ;color:red'>History insert failed</div>";
        die("DBase insert failed: " . mysqli_query_error());
}
$result = mysqli_query($conn,"UPDATE `pole_history` set resp_time = $now  where poleid = '$poleid' and resp_time = 0 ");
if(!$result) {
        echo "<div style='font-size:25px ;color:red'>History update failed</div>";
        die("DBase update failed: " . mysqli_query_error());
}
$result = mysqli_query($conn,"UPDATE `sub_light` set rport_time = 0  where poleid = '$poleid' ");
if(!$result) {
        echo "<div style='font-size:25px ;color:red'>Report update failed</div>";
        die("DBase report time update failed: " . mysqli_query_error());
}
$conn->close();
?>
