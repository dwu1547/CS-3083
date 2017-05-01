<html>
<head>
</head>
<body>
<?php
	require('connect.php');
	$int = htmlspecialchars(strip_tags(trim($_GET['chooseInt'])));
	//echo $int;
	$inpINT = "'".$int."'";
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "SELECT groups.group_id,groups.group_name,groups.description,groups.username from groups,about
	where groups.group_id = about.group_id AND about.interest_name = $inpINT";
	$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
echo "<table>";
echo "<tr><td>","Group_id","</td><td>","Group_Name","</td><td>","Description","</td><td>","Creator","</td><tr>";
	while($row =mysqli_fetch_assoc($result)){
		echo"<tr><td>",$row['group_id'],"</td><td>".$row['group_name'],"</td><td>",$row['description'],
		"</td><td>",$row['username'],"</td></tr>";
	}
echo"</table>";
}
else {
echo "0 results";
}
$conn->close();
?>
<input type="button" value="Go back to starting page" class="button_active" onclick="location.href='meetindex.php';">
</body>
</html>