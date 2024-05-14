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

echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
echo '<table class="data-table table table-striped table-bordered">
        <tr class="data-heading">';  //initialize table tag
echo '<td style="color:white; text-align:center; background-color:#215787"><strong>'.Lastpole.'</strong></td>';
echo '<td style="color:white; text-align:center; background-color:#215787"><strong>'.Sub.'</strong></td>';
echo '</tr>'; //end tr tag
  while($subrow=mysqli_fetch_array($result)) {
    $cursub = $subrow[0];
    $lastpole = mysqli_query($conn, "SELECT poleid from `sub_light` where groupname='$cursub'
	    			Order by poleid and substring(poleid,5,5) DESC limit 1");
    $row=mysqli_fetch_array($lastpole);  
      echo '<tr>';
      echo '<td>'.$row[0].'</td>';
      echo '<td>'.$cursub.'</td>';
      echo '</tr>';
  }
$conn->close();
?>
