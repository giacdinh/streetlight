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
</head>
<body">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="main.css">
<div class="header">
<!--    <span class="v2"></span><a href=https://p-micro.duke-energy.com/one/outdoor-lighting><img style="width:100px;" src="/img/dukeone.svg"></a>-->
    <span class="v1"></span> DE One Light and Pole Status
 </div>
<div class="topnav" style="font-size:22px">
<ul> <li> <a>
    <form action="polesearch.php" method="get"> <label style="color:white">Enter exact or nearby Pole#: </label>
      <input type="text" name="poleid" size=20 />
      <input type="submit" value="Search Pole" />
    </form>
</a> </li>
<div class="topnav-right">
  <li><a class="active" href="./index.php">Home</a></li>
<li><a target="popup" onclick="window.open('', 'popup', 'width=580,height=360,scrollbars=no, toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10')" href="sendMail.php">Contact</a></li>

</div>
</ul>
<br><br>
<div style ="text-align:center">
        <form action="authenticate.php" method="post">
                <label for="username">
                    <i class="fas fa-user"></i> User:
                </label>
                <input style="font-size:22px;" type="text" name="username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i> Password:
                </label>
                <input style="font-size:22px;" type="password" name="password" id="password" required>
                <input style="font-size:22px;" type="submit" value="Login" >
            </form>
</div>

    
</body>
</html>
