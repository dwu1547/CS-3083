<?php
	session_start();
	require('connect.php');
	
	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		header("refresh:2; url=main.html");
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
	<div>
		<h1> Welcome to MeetUp - Start Your Groups Now </h1>
		<span> Current signed in as <?php echo $_SESSION['user'] ?> </span>
	</div>
	<h3> <a href="sortEvents2.php"> Click here to look through your events </a></h3>
	<h3> <a href="makegroup.php"> Want to make a new group? Click here. </a></h3>
	<h3> <a href="createEvent.php"> Want to create a new event? Click here. </a></h3>

	<form action="logout.php">
		<input type="submit" value="Logout">
	</form>
</body>
</html>