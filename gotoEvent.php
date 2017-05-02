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
	echo $eve_id;
	echo "<br>";
	echo $ans;
	
	$sql ="UPDATE ATTEND SET rsvp = $ans WHERE event_id = $eve_id AND username ='".$_SESSION['user']."'";
	if ($conn->query($sql) === TRUE) {
		echo "Attendence for event $eve_id updated successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>