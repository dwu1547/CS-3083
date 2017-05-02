<?php
require('connect.php');
	session_start();

	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		session_unset();
    	session_destroy();
		header("refresh:2; url=main.php");
	}
	
	$eve_id = "'".$_GET['chooseEve']."'";
	$ans = $_GET['yesorno'];
	echo "Event ID: ".$eve_id;
	echo "<br>";
	echo "RSVP: ".$ans;
	echo "<br>";
	
	$sql ="UPDATE ATTEND SET rsvp = $ans WHERE event_id = $eve_id AND username ='".$_SESSION['user']."'";
	if ($conn->query($sql) === TRUE) {
		echo "Attendence for event $eve_id updated successfully";
		?>
			<!DOCTYPE html>
			<html>
			<head>			
			</head>
			<body>
				<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
			</body>
			</html>
		<?php
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>