<?php
	require('connect.php');
	# Check if session existed ? reset : nothing
	if (session_status() != PHP_SESSION_NONE) {
    	session_unset();
    	session_destroy();
	}
	if(isset($_SESSION))
		echo "existing session";

	# change password length to match hash password length
	$sql = "ALTER TABLE member CHANGE password password VARCHAR(60)";
	if(!mysqli_query($conn, $sql)) {
		echo mysqli_error($conn);
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
	<h1> MeetUp - Find Friends Simulator </h1>
	<div class="registration"> 
		<a href="registration.php"> Didn't make an account? Register Here! </a>
	</div>
	<div class="login">
		<a href="login.php"> Login Here! </a>
	</div>

</body>
</html>