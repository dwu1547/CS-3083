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
		$gID = htmlspecialchars(strip_tags(trim($_POST['selgroupID'])));
		$interest = ucfirst(htmlspecialchars(strip_tags(trim($_POST['gInterest']))));

		#echo $gID.' '.$interest;

		$fields = array('selgroupID', 'gInterest');

		# Check field errors
		foreach($fields AS $index) {
			if(!isset($_POST[$index]) || empty($_POST[$index])) {
				$error = 'Required field is missing!';
				break;
			}
		}

		# Check if same group same interest
		$check1 = "SELECT * FROM about WHERE interest_name = '$interest' AND group_id = '$gID'";
		$qry = mysqli_query($conn, $check1);
		if($qry && mysqli_num_rows($qry) > 0) {
			$error = 'Group with similar interest already exists.';
		}

		# Insert into database
		if(!isset($error) && empty($error)) {
			$sql = "INSERT INTO interest (interest_name) VALUES ('$interest');";
			$sql .= "INSERT INTO about (interest_name, group_id) 
				SELECT interest_name, group_id FROM interest, groups WHERE interest_name = '$interest' AND group_id = '$gID'";

			$sql2 = "INSERT INTO about (interest_name, group_id) 
				SELECT interest_name, group_id FROM interest, groups WHERE interest_name = '$interest' AND group_id = '$gID';";
			$sql2 .= "INSERT INTO interest (interest_name) VALUES ('$interest')";

			$selInterest = "SELECT * FROM interest WHERE interest_name = '$interest'";
			$checkInterest = mysqli_query($conn, $selInterest);
			if($checkInterest && mysqli_num_rows($checkInterest) == 0)	{
				#echo "No interest in table";
				if(mysqli_multi_query($conn, $sql)) {
					echo "<h2> Successfully added new interest.";
					echo "<a href='makeInterest.php'> Click here to go back </a> </h2>"; 
				}
			}
			elseif($checkInterest && mysqli_num_rows($checkInterest) > 0) {
				#echo "Some interest in table";
				if(mysqli_multi_query($conn, $sql2)) {
					echo "<h2> Successfully added new interest.";
					echo "<a href='makeInterest.php'> Click here to go back </a> </h2>"; 
				}
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
				echo "<a href='makeInterest.php'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>