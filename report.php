<html>
    <head>
<style>
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
    </head>

    <body>
<div class="header">
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE One Light and Pole Status
</div>
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

$result = mysqli_query($conn, "SELECT groupname,poleid,gpsx,gpsy,report,notes,FROM_UNIXTIME(rport_time),cust_resp FROM `sub_light` where rport_time != 0 ORDER by rport_time DESC");

//$result = mysqli_query($conn, "SELECT groupname,poleid,report,FROM_UNIXTIME(rport_time),cust_resp,cust_note,resp_time FROM `pole_history` where resp_time=0 ORDER by rport_time DESC");

$all_property = array();  //declare an array for saving property

//showing property
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
echo '<table class="data-table table table-striped table-bordered">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
    array_push($all_property, $property->name);  //save those to array
}
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Select. '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Groupname . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . 'Pole#' . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . GPSx . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . GPSy . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Issue . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Note . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Reporttime. '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Contact . '</strong></td>';
echo '</tr>'; //end tr tag

//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
   echo '<td><form action="/pole_history.php"><input type="checkbox" name="poleid" value="' .$row[1]. '"><input type="submit" value="Fixed"></form></td>';
    foreach ($all_property as $item) {
        echo '<td>' . $row[$item] . '</td>'; //get items using property value
    }
    echo '</tr>';
}
echo "</table>";
$conn->close();
?>
