<?php
	require('connect.php');
	session_start();

	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		header("refresh:2; url=main.php");
	}

	if(isset($_POST['submit'])) {
		$eID = htmlspecialchars(strip_tags(trim($_POST['eID'])));
		$eTitle = htmlspecialchars(strip_tags(trim($_POST['eTitle'])));
		$desc = htmlspecialchars(strip_tags(trim($_POST['desc'])));
		$startDate = htmlspecialchars(strip_tags(trim($_POST['from'])));
		$endDate = htmlspecialchars(strip_tags(trim($_POST['to'])));
		$startTime = htmlspecialchars(strip_tags(trim($_POST['startTime'])));
		$endTime = htmlspecialchars(strip_tags(trim($_POST['endTime'])));
		$selgroupID = htmlspecialchars(strip_tags(trim($_POST['selgroupID'])));
		$selLocName = htmlspecialchars(strip_tags(trim($_POST['selLoc'])));		# white space issue 

		// echo "event id: ".$eID."<br>";
		// echo "eTitle: ".$eTitle."<br>";
		// echo "desc: ".$desc."<br>";
		// echo $startDate.' '.$endDate."<br>";
		// echo "start time: ".$startTime.' '."endTime: ".$endTime."<br>";
		// echo "24 hr format starttime: ".date("G:i", strtotime($startTime))."endtime: ".date("G:i", strtotime($endTime))."<br>";
		// echo "group ID: ".$selgroupID."<br>";
		// echo "location name: ".$selLocName."<br>";
		
		# Check for field errors
		$fields = array('eID', 'eTitle', 'desc', 'from', 'to', 'startTime', 'endTime', 'selgroupID', 'selLoc');

		foreach($fields AS $index) {
			if(!isset($_POST[$index]) || empty($_POST[$index])) {
				echo $_POST[$index];
				$error = 'Required field is missing!';
				break;
			}
		}

		# Check for same event ID
		$selID = "SELECT * FROM events WHERE event_id = '$eID'";
		$qry = mysqli_query($conn, $selID);
		if($qry && mysqli_num_rows($qry) > 0)
			$error = 'Event ID taken.';

		# Check if user is authorized to make new event
		$selAuthority = "SELECT * FROM belongs_to WHERE username = '".$_SESSION['user']."' AND group_id = '$selgroupID' AND authorized = 1";
		$qry = mysqli_query($conn, $selAuthority);
		if($qry && mysqli_num_rows($qry) === 0) 
			$error = "User is NOT authorized to create new event.";		

		# Split location string
		$locSplit = explode("|", $selLocName);
		$locName = $locSplit[0];
		$locZip = $locSplit[1];

		# Convert time into H:i:s format and date to Y:m:d
		$sTimeForm = date("G:i:s", strtotime($startTime));
		$eTimeForm = date("G:i:s", strtotime($endTime));
		$sDateForm = date("Y-m-d", strtotime($startDate));
		$eDateForm = date("Y-m-d", strtotime($endDate));

		# Convert to SQL datetime type
		$sdateTime = $sDateForm.' '.$sTimeForm;
		$edateTime = $eDateForm.' '.$eTimeForm;
		
		if(!isset($error) && empty($error)) {
			$insEvent = "INSERT INTO events (event_id, title, description, start_time, end_time, group_id, lname, zip)
				VALUES ('$eID', '$eTitle', '$desc', '$sdateTime', '$edateTime', '$selgroupID', '$locName', '$locZip')";

			if(mysqli_query($conn, $insEvent)) {
				echo "<h2> Successfully added new event.";
				echo "<a href='meetindex.php'> Click here to go back </a> </h2>";
			}
			else
				echo 'ERROR: '.mysqli_error($conn);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="main.css">
</head>
<body>
	<div class="_error">
		<?php 
			if(isset($error)) {
				echo 'ERROR: '.$error.'<br>';
				echo "<a href='createEvent.php'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>