<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
$poleid = $_GET['poleid'];
$issue = $_GET['poleissue'];
$contact = $_GET['cinfo'];
  
echo "PoleID: $poleid with $issue <br>";
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
$rquery = "UPDATE `sub_light` set report='$issue',rport_time=$now,cust_resp='$contact' where poleid=\"$poleid\"";
echo $rquery;
$result = mysqli_query($conn, $rquery);
if(!$result) {
        echo "<div style='font-size:75px ;color:red'>DBase update failed.</div>";
        die("DBase insert failed: " . mysqli_query_error());
}
echo "<div style='font-size:75px ;color:green'>Update pole issue report successed</div>";

$conn->close();


?>
