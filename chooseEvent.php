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
	$syear = $_GET['startyr'];
	//echo"START YEAR:";
	//echo $syear;
	//echo"<br>";
	$smonth = $_GET['startmth'];
	//echo"START MONTH:";
	//echo $smonth;
	//echo"<br>";
	$sdate = $_GET['startdt'];
	//echo"START DATE:";
	//echo $sdate;
	//echo"<br>";

	$eyear = $_GET['endyr'];
	//echo"END YEAR:";
	//echo $eyear;
	//echo"<br>";
	$emonth = $_GET['endmth'];
	//echo"END MONTH:";
	//echo $emonth;
	//echo"<br>";
	$edate = $_GET['enddt'];
	//echo $edate;
	//echo"<br>";
	//echo "TEST<br>";
	//echo $syear.'-'.$smonth."-".$sdate;
	//echo "<br>";
	echo"<h2> START DATE: ";
	$totstart =($syear.'-'.$smonth.'-'.$sdate);
	echo $totstart,"</h2>";
	echo"<h2> END DATE:";
	$totend =($eyear.'-'.$emonth.'-'.$edate);
	echo $totend,"</h2>";

	$ssinput="'".$totstart."'";
	$eeinput="'".$totend."'";
	
	$sql="select event_id,title,description,start_time,end_time,group_id,lname,zip
	from(select event_id,title,description,start_time,end_time,group_id,lname,zip
	from(select event_id,title,description,start_time,end_time,group_id,lname,zip from events
	where start_time>=$ssinput)as T
	where T.end_time<=$eeinput)as S 
	where S.group_id IN 
	(select group_id from 
	groups where username ='".$_SESSION['user']."')";
	
	if($result = $conn->query($sql)){
	if ($result->num_rows > 0) {
    // output data of each row
	echo "<table>";
		while($row = mysqli_fetch_array($result))
		{
		//echo "<br>", $row['group_id'],"</br>";
			echo "<tr><td>".$row['event_id']."</td><td>".$row['title']."</td><td>".$row['description']."</td><td>".$row['start_time'].
			"</td><td>".$row['end_time']."</td><td>".$row['group_id']."</td><td>".$row['lname']."</td><td>".$row['zip']."</td></tr>";
		} 
	echo "<table>";
	
	}	
	}
	else {
    echo "0 events invited";
	}
	if($result2 = $conn->query($sql)) {
	if($result2->num_rows > 0){
	echo "<form action='gotoEvent.php' method='get'>";
	echo "Event ID: <select name='chooseEve'>";
	while($row = mysqli_fetch_array($result2))
		{
		//echo "<br>", $row['group_id'],"</br>";
			echo "<option>".$row['event_id']."</option>";
		} 
	echo "</select>";
	echo "RSVP: <select name='yesorno'>";
	echo"<option>"."0"."</option>";
	echo"<option>"."1"."</option>";
	echo"</select>";
	echo "<br>";
	echo "<input type='submit'>";
	echo "</form>";
	}
	}
	else {
		echo "0 events to select";
	}
	$conn->close();
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
				echo "<a href='makeEvent.php'> Click here to go back </a>";
			}
		?> 
	</div>
</body>
</html>