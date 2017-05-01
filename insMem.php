<?php
    require('connect.php');
    session_start();
    
    # Check if user is logged in or not
    if(!isset($_SESSION['user'])) {
      echo "User is not signed in";
      session_unset();
      session_destroy();
      header("refresh:2; url=main.php");
    }

    if(isset($_POST['submit'])) {
    	$gID = htmlspecialchars(strip_tags(trim($_POST['selgroupID'])));
    	$user = htmlspecialchars(strip_tags(trim($_POST['selUser'])));
    	$auth = htmlspecialchars(strip_tags(trim($_POST['authorize'])));

    	$fields = array('selgroupID', 'selUser', 'authorize');

		# Check if member is in group already
		$check = "SELECT * FROM belongs_to WHERE group_id = '$gID' AND username = '$user'";
		if($qry = mysqli_query($conn, $check)) {
			if($qry && mysqli_num_rows($qry)) {
				$error = "Member is already inside this group.";
			}
		}

		# Insert into database
		if(!isset($error) && empty($error)) {			
			$ins = "INSERT INTO belongs_to (group_id, username, authorized) VALUES ('$gID', '$user', '$auth')";
			if($qry = mysqli_query($conn, $ins)) {				
				echo "<h2> Member is now in the group.";
				echo "<a href='makeUserJoin.php'> Click here to go back </a></h2>";
			}
			else
				echo "ERROR: ".mysqli_error($conn);	
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
				echo "<a href='makeUserJoin.php'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>