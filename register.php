<?php
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$usern = $_POST['username'];
	$passw = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$valid = $_POST['pass_valid'];

	$fields = array('fname', 'lname', 'email', 'username', 'password', 'pass_valid');
	foreach($fields AS $index) {
		if(!isset($_POST[$index]) || empty($_POST[$index])) {
			$error = 'Required field is missing!';
		}
		else {
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error = 'Invalid email';
			}
			if(strlen($_POST['password']) < 6) {
				$error = 'Password too short';
			}
			else {
				if($_POST['password'] === $_POST['pass_valid']) 
					# echo "Successfully registered.";
					;
				else
					$error = "Passwords do not match.";
			}
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
</head>
<body>
<?php
	if(isset($error)) {
		echo 'ERROR: '.$error;
		echo "<a href='registration.php'> Click here to go back </a>";
	}
?>
</body>
</html>