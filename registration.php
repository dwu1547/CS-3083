<?php
	# Check if session existed ? reset : nothing
	if (session_status() != PHP_SESSION_NONE) {
    	session_unset();
    	session_destroy();
	}
	if(isset($_SESSION))
		echo "existing session";
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
	<div class="container-fluid">
		<form class="register" method="POST" action="register_sess.php">
			<h2> New User Registration </h2>
			<div class="_fullname">
				<label for="fname" >First Name: </label>
				<!-- pattern is for HTML5 and up -->
				<input type="text" name="fname" id="fname" maxlength="50" pattern="[A-Za-z]{2,}" title="Characters Only">	
				<label for="lname" >Last Name: </label>
				<input type="text" name="lname" id="lname" maxlength="50" pattern="[A-Za-z]{2,}" title="Characters Only">
			</div>
			<div class="_email">
				<label for="email" >Email Address:</label>
				<input type="text" name="email" id="email" maxlength="50" placeholder="jsmith123@gmail.com">
			</div>
			<div class="_zipcode">
				<label for="zipcode" >Zipcode:</label>
				<input type="number" name="zipcode" id="zipcode" pattern=".{5,5}" min="10000" max="99999">
			</div>
			<div class="_user">
				<label for="username" >UserName:</label>
				<input type="text" name="username" id="username" maxlength="50">
			</div>
			<div class="_pass">
				<label for="password" >Password:</label>
				<input type="password" name="password" id="password" maxlength="50">
				<label for="pass_valid" >Retype Password:</label>
				<input type="password" name="pass_valid" id="pass_valid" maxlength="50">
			</div>
			<div>
				<input type="submit" name="submit" value="Submit">
				<input type="button" value="Go Back" class="button_active" onclick="location.href='main.php';">
			</div>
		</form>
	</div>

	<script type="text/javascript">

	</script>
</body>
</html>