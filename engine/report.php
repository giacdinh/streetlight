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

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn) {
	echo "DBase connect failed";
	die("Connection failed: " . mysqli_connect_error());
	echo "DBase connect failed";
}

$result = mysqli_query($conn, "SELECT groupname,poleid,gpsx,gpsy,ptype,pheight,bulbtype,report,FROM_UNIXTIME(rport_time),cust_resp FROM `sub_light` where rport_time != 0 ORDER by rport_time DESC");

$all_property = array();  //declare an array for saving property

//showing property
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
echo '<table class="data-table table table-striped table-bordered">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
//    echo '<td><strong>' . strtoupper($property->name) . '</strong></td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . groupname . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . poleid . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . gpsx . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . gpsy . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . ptype . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . pheight . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . bulbtype . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . report . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . report_time . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#4CAF50"><strong>' . customer_info . '</strong></td>';
echo '</tr>'; //end tr tag

//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    foreach ($all_property as $item) {
        echo '<td>' . $row[$item] . '</td>'; //get items using property value
    }
    echo '</tr>';
}
echo "</table>";
$conn->close();
?>
