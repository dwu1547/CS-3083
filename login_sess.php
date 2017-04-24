<?php
	require('connect.php');
	session_start();
	
	if(isset($_POST['submit'])) {
		$usern = $_POST['username'];
		$passw = $_POST['password'];
		$fields = array('username', 'password');
		
		# Check field errors
		foreach($fields AS $index) {
			if(!isset($_POST[$index]) || empty($_POST[$index])) {
				$error = 'Required field is missing!';
				break;
			}
		}
		
		# Check password matching
		$selUser = "SELECT * FROM member WHERE username = '$usern'";
		$result = mysqli_query($conn, $selUser);
		if($result && mysqli_num_rows($result) === 1) {			
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);			
			if(password_verify($passw, $row['password'])) {
				$_SESSION['user'] = $usern;
				header("Location: meetindex.html");
			}
			else {
				$error = 'Invalid login or password';
			}
		}
		else {
			$error = 'Invalid login or password';
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
				echo "<a href='login.html'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>