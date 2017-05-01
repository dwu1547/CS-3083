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
		<div class="row">
			<div class="col-md-6">
				<form class="makeGroupInterest" method="POST" action="insGroupIntr.php">
					<h2> Current Group Interest </h2>
					<div class="_gID">
						<?php
							$selgID = "SELECT group_id FROM groups where username = '".$_SESSION['user']."'";
							if($qry = mysqli_query($conn, $selgID)) {
								if($qry && mysqli_num_rows($qry) > 0) {
									echo "<label for='gID'> Group ID: &nbsp</label>";
									echo "<select name='selgroupID'>";
									while($row = mysqli_fetch_assoc($qry)) {
										#echo $row["group_id"].' ';
										echo "<option value=".$row["group_id"]."> ".$row["group_id"]." </option>";
									}
									echo "</select>";
								}
								else {
									echo "<script> alert('You are not in a group! Please join or create a group.') </script>";
									header("refresh: 0.1; url=makegroup.php"); 
								}
							}
							else
								echo 'ERROR: '.mysqli_error($conn);	
						?>
					</div>
					<div class="_interest">
						<label for="interest"> Group Interest: </label>
						<input type="text" name="gInterest" id="gInterest" maxlength="20">
					</div>
					<div> 
						<input type="submit" name="submit" value="Add new group interest">
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<form class="makeUserInterest" method="POST" action="insUserIntr.php">
					<h2> User Interest </h2>
					<div class="_interest">
						<label for="interest"> Group Interest: </label>
						<input type="text" name="gInterest" id="gInterest" maxlength="20">
					</div>
					<div> 
						<input type="submit" name="submit" value="Add new user interest">
					</div>
				</form>
			</div>
		</div>
		<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
	</div>

		
</body>
</html>