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
    	$selUser = htmlspecialchars(strip_tags(trim($_POST['selUser'])));
      $stringSplit = explode("|", $selUser);
    	$user = $stringSplit[0];
      $gID= $stringSplit[1];
    	$auth = htmlspecialchars(strip_tags(trim($_POST['authorize'])));

      #echo "user: ".$selUser.' user: '.$user.' gID: '.$gID.' auth: '.$auth;
      # Check field errors
      

      if(!isset($error) && empty($error)) { 
        $update = "UPDATE belongs_to SET authorized = '$auth' WHERE group_id = '$gID' AND username = '$user'";
        if($qry = mysqli_query($conn, $update)) {
          echo "<h2> Member authority changed.";
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