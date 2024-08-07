<html>
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

    </head>
    <body>
<div class="header">
    <span class="v1"></span><font face="Roboto"> DE One Light and Pole Status
 </div>
    </body>
</html>
<?php
$subname = $_GET["subselect"];

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

//$result = mysqli_query($conn, "SELECT groupname,poleid,gpsx,gpsy FROM `sub_light` order by CHAR_LENGTH(poleid),poleid");
//$result = mysqli_query($conn, "SELECT groupname,poleid,gpsx,gpsy FROM `sub_light` order by CHAR_LENGTH(poleid),poleid and substring(poleid,5,5)");
$result = mysqli_query($conn, "SELECT groupname,poleid,gpsx,gpsy FROM `sub_light` order by SUBSTR(poleid from 1 for 1),CAST(SUBSTR(poleid FROM 2) AS UNSIGNED)");

$all_property = array();  //declare an array for saving property
$rowcnt = mysqli_num_rows($result);
echo '<p style="font-size: 200%; color:black"><strong>This subdivision has '.$rowcnt.' lights</strong></p>';


//showing property
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
echo '<table class="data-table table table-striped table-bordered">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
//    echo '<td><strong>' . strtoupper($property->name) . '</strong></td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Groupname . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . 'Pole#' . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . GPSx . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . GPSy . '</strong></td>';
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
