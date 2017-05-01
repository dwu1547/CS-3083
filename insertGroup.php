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

	if(isset($_POST['submit'])) {
		$id = htmlspecialchars(strip_tags(trim($_POST['gID'])));
		$name = htmlspecialchars(strip_tags(trim($_POST['gName'])));
		$desc = htmlspecialchars(strip_tags(trim($_POST['desc'])));
		$interest = ucfirst(htmlspecialchars(strip_tags(trim($_POST['gInterest']))));

		$fields = array('gID', 'gName', 'desc', 'gInterest');

		# Check field errors
		foreach($fields AS $index) {
			if(!isset($_POST[$index]) || empty($_POST[$index])) {
				$error = 'Required field is missing!';
				break;
			}
		}

		# Check if group ID exists
		$selID = "SELECT * FROM groups WHERE group_id = '$id'";
		$qry = mysqli_query($conn, $selID);
		if($qry && mysqli_num_rows($qry) > 0)
			$error = 'Group ID taken.';

		# Check if similar ID and interest exists
		$selSameG = "SELECT * FROM about WHERE group_id = '$id' AND interest_name = '$interest'";
		$qry2 = mysqli_query($conn, $selSameG);
		if($qry2 && mysqli_num_rows($qry2) > 0)
			$error = 'Group with similar interest already exists.';

		# Insert into database
		if(!isset($error) && empty($error)) {
			$sql = "INSERT INTO groups (group_id, group_name, description, username)
				VALUES ('$id', '$name', '$desc', '".$_SESSION['user']."');";

			$sql .= "INSERT INTO belongs_to (group_id, username, authorized)
				VALUES ('$id', '".$_SESSION['user']."', 1);";

			$sql .= "INSERT INTO about (interest_name, group_id) 
					SELECT interest_name, group_id FROM interest, groups WHERE interest_name = '$interest' AND group_id = '$id';";

			$sql .= "INSERT INTO interest (interest_name) 
				VALUES ('$interest')";

			if(mysqli_multi_query($conn, $sql)) {
				echo "<h2> Successfully added new group.";
				echo "<a href='meetindex.php'> Click here to go back </a> </h2>"; 
			}
		}
		mysqli_close($conn);
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
				echo "<a href='makegroup.php'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>