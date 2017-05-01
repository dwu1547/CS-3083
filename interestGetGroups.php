<?php
	require('connect.php');
	session_start();
	
	# Check if user is logged in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		session_unset();
    	session_destroy();
		header("refresh:2; url=main.php");
	}
	
	echo "<span style='font-size: 18px;'> Current signed in as ".$_SESSION['user']." </span>";
?>
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
	if($result = $conn->query($sql)) {
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
	}
	else
		echo 'ERROR: '.mysqli_error($conn);	
	$conn->close();
?>
<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
</body>
</html>