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
		$rating = $_POST['rating'];
		$eID = $_POST['selEventID'];
		#echo $rating.' '.$eID;

		$sql = "UPDATE attend SET rating = '$rating' WHERE event_id = '$eID' AND username = '".$_SESSION['user']."'";
		if($qry = mysqli_query($conn, $sql)) {
			echo "<script> alert('Thanks for rating the event.') </script>";
		}
		else
			echo 'ERROR: '.mysqli_error($conn);	
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
				echo "<a href='meetindex.php'> Click here to go back </a>";
			}
		?> 
	</div>

	<div class="container-fluid">
		<form class="rateEvent" method="POST" action="">
			<h2> Rate attended events </h2>
			<div class="_eventsAttend">
				<?php
					$sql = "SELECT event_id FROM attend WHERE username = '".$_SESSION['user']."' AND rsvp = 1 AND ";
					if($qry = mysqli_query($conn, $sql)) {
						if($qry && mysqli_num_rows($qry) > 0) {
							echo "<label for='eID'> Event ID: &nbsp</label>";
							echo "<select name='selEventID'>";
							while($row = mysqli_fetch_assoc($qry)) {
								#echo $row["group_id"].' ';
								echo "<option value=".$row["event_id"]."> ".$row["event_id"]." </option>";
							}
							echo "</select>";
						}
					}
					else
						echo 'ERROR: '.mysqli_error($conn);	
				?>
			</div>
			<div class="_rate">
				<label for="rating"> Ratings: </label>
				<select name="rating">
					<option value="10"> 10 </option>
					<option value="9"> 9 </option>
					<option value="8"> 8 </option>
					<option value="7"> 7 </option>
					<option value="6"> 6 </option>
					<option value="5"> 5 </option>
					<option value="4"> 4 </option>
					<option value="3"> 3 </option>
					<option value="2"> 2 </option>
					<option value="1"> 1 </option>
				</select>
			</div>
			<input type="submit" name="submit" value="Rate the event">
		</form>
		<input type="button" value="Go Back" class="button_active" onclick="location.href='meetindex.php';">
	</div>

</body>
</html>