<?php
	require('connect.php');
	session_start();
	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		header("refresh:2; url=main.html");
	}
	
	echo "<span> Current signed in as ".$_SESSION['user']." </span>";

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
				echo "<a href='meetindex.php'> Click here to go back </a>";
			}
		?> 
	</div>

	<div class="container-fluid">
		<form class="makeNewGroup" method="POST" action="insertGroup.php">
			<h2> Create a new group </h2>
			<div class="_gID">
				<label for="gID"> Group ID: </label>
				<input type="number" name="gID" id="gID" min="1" max="99999999999999999999">
			</div>
			<div class="_gName">
				<label for="gName"> Group Name: </label>
				<input type="text" name="gName" id="gName" maxlength="20">
			</div>
			<div class="_desc">
				<label for="desc"> Description: </label>
				<textarea name="desc" id="desc" rows="10" cols="40"></textarea>
			</div>
			<div> 
				<input type="submit" name="submit" value="Make New Group">
				<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
			</div>
		</form>
	</div>
</body>
</html>