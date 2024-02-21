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
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE ONE Light and Pole Status
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

$result = mysqli_query($conn, "SELECT groupname FROM `groups_light`");

$all_property = array();  //declare an array for saving property
$rowcnt = mysqli_num_rows($result);
echo '<p style="font-size: 200%; color:black"><strong>This customer has '.$rowcnt.' subdivision</strong></p>';


//showing property
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
echo '<table class="data-table table table-striped table-bordered">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
//    echo '<td><strong>' . strtoupper($property->name) . '</strong></td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Subdivion . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Poles . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Monthly . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Quarterly . '</strong></td>';
   echo '<td style="color:white; text-align:center; background-color:#215787"><strong>' . Annually . '</strong></td>';
echo '</tr>'; //end tr tag

//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    foreach ($all_property as $item) {
	    $group = $row[$item];
        echo '<td>' . $group . '</td>'; 
	$detail = mysqli_query($conn, "SELECT * FROM `sub_light` where groupname='$group' ");
	$npole = mysqli_num_rows($detail);
        echo '<td>' . $npole . '</td>'; 
	$service = $npole*10 / 100;
        echo '<td>'.'$'. $service . '</td>'; // Monthly
        echo '<td>'.'$'. $service*3 . '</td>'; // Monthly
        echo '<td>'.'$'. $service*12 . '</td>'; // Monthly
	$total = $total + $service;
	$ptotal = $ptotal + $npole;
    }
    echo '</tr>';
}
    echo '<td><strong>Total</td><td>'.$ptotal.'</td><td><strong>$'.$total .'</td>';
    $quarter = $total*3;
    $year = $total*12;
    echo '<td><strong>$'.$quarter.'</td>';
    echo '<td><strong>$'.$year.'</td>';
echo "</table>";
$conn->close();
?>
