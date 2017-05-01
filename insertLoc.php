<html>
<head>
<style>
span.ch{
	color:red;
}
</style>
</head>
<body>
<?php
require('connect.php');

$loc = htmlspecialchars(strip_tags(trim($_GET['Locname'])));
echo $loc;
echo "<br>";
$street = htmlspecialchars(strip_tags(trim($_GET['Stname'])));
echo $street;
echo "<br>";
$city = htmlspecialchars(strip_tags(trim($_GET['Ctname'])));
echo $city;
echo "<br>";
$zip = htmlspecialchars(strip_tags(trim($_GET['Zname'])));
echo $zip;
echo "<br>";
$Lat = htmlspecialchars(strip_tags(trim($_GET['Latname'])));
echo $Lat;
echo "<br>";
$Long = htmlspecialchars(strip_tags(trim($_GET['Lngname'])));
echo $Long;
echo "<br>";
$Desc = htmlspecialchars(strip_tags(trim($_GET['Desc'])));
echo $Desc;
echo "<br>";

$check = False;
if(!isset($loc) || trim($loc) == ''){
	echo '<span class="ch">Missing Location Name</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($street) || trim($street) == ''){
	echo '<span class="ch">Missing Street Name</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($city) || trim($city) == ''){
	echo '<span class="ch">Missing City Name</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($zip) || trim($zip) == ''){
	echo '<span class="ch">Missing Zipcode</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($Lat) || trim($Lat) == '' || filter_var($Lat,FILTER_VALIDATE_FLOAT) === False){
	echo '<span class="ch">Missing Latitude or not a decimal</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($Long) || trim($Long) == '' || filter_var($Long,FILTER_VALIDATE_FLOAT) === False){
	echo '<span class="ch">Missing Longitude or not a decimal</span> <br>';
	$check = False;
}
else{
	$check = True;
}
if(!isset($Desc) || trim($Desc) == ''){
	echo '<span class="ch">Missing Description</span> <br>';
	$check = False;
}
else{
	$check = True;
}
$inLoc="'".$loc."'";
$inZip=(int)$zip;
$inStreet="'".$street."'";
$inCity="'".$city."'";
$inDesc="'".$Desc."'";
$inLat=(float)$Lat;
$inLong=(float)$Long;
if($check == True){
	// Check connection
	if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	}
	$sql ="INSERT INTO Location VALUES($inLoc,$inZip,$inStreet,$inCity,$inDesc,$inLat,$inLong)";
	if ($conn->query($sql) === TRUE) {
		echo "<h2> New record created successfully. ";
		echo "<a href='meetindex.php'> Click here to go back </a> </h2>";
	} 
	else 
		echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
</body>
</html>