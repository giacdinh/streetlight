<!DOCTYPE html>
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
    <span class="v2"></span><img style="width:100px;" src="/img/dukeone.svg">
    <span class="v1"></span><font face="Roboto">Street & Area Light Repair
 </div>

<form action="mailto:deoneflsl@duke-energy.com" method="post" enctype="text/plain">
Subject:<br>
<input type="text" name="name"><br>
Phone or email:<br>
<input type="text" name="mail" placeholder="required"><br>
Comment:<br>
<textarea name="Contact-Message" rows="6" cols="50">
    </textarea><br><br>
<input type="submit" value="Send">
<input type="reset" value="Reset">
<button onclick="self.close()">Close</button>
</form>

</body>
</html>
