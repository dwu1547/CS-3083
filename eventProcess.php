<?php
	require('connect.php');
	session_start();

	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		header("refresh:2; url=main.html");
	}

	if(isset($_POST['submit'])) {
		$eID = $_POST['eID'];
		$eTitle = $_POST['eTitle'];
		$desc = $_POST['desc'];
		$startDate = $_POST['from'];
		$endDate = $_POST['to'];
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];
		$selgroupID = $_POST['selgroupID'];
		$selLocName = $_POST['selLoc'];		# white space issue 

		// echo $startDate.' '.$endDate;
		// echo "group ID: ".$selgroupID;
		// echo "location name: ".$selLocName;
		// echo "start time: ".$startTime.' '."endTime: ".$endTime;
		// echo "24 hr format starttime: ".date("G:i", strtotime($startTime))."endtime: ".date("G:i", strtotime($endTime)).". ";

		# Check for same event ID

		# Check for field errors
		$fields = array('eID', 'eTitle', 'desc', 'from', 'to', 'startDate', 'endDate', 'startTime', 'endTime', 'selgroupID', 'selLoc');

		foreach($fields AS $index) {
			if(!isset($_POST[$index]) || empty($_POST[$index])) {
				$error = 'Required field is missing!';
				break;
			}
		}

		# Check if user is authorized to make new event
		/* $selAuthority = "SELECT * FROM belongs_to WHERE username = '".$_SESSION['user']."' AND authorized = 1";
		$qry = mysqli_query($conn, $selAuthority);
		if($qry && mysqli_num_of_rows($qry) > 0) {
			# Insert new event
		} */
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