<!DOCTYPE>
<html>
<head>
</head>
<body>
<div>SELECT INTEREST TO GET GROUPS</div>
<br>
<?php
	require('connect.php');
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "SELECT * from interest";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
	echo "<form action='interestShowGroups.php' method='get'>";
	echo "<select name='chooseInt'>";
		while($row = mysqli_fetch_array($result))
		{
		//echo "<br>", $row['group_id'],"</br>";
			echo "<option>".$row['interest_name']."</option>";
		} 
	echo "</select>";
	echo "<input type='submit'>";
	echo "</form>";
	}
	
	else {
    echo "0 results";
	}
	$conn->close();
?>
<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
</body>
</html>