<html>
<body>
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

	$sql ="
	select event_id,title,description,start_time,end_time,group_id,lname,zip
	from(select event_id,title,description,start_time,end_time,group_id,lname,zip from events
	where start_time>=$ssinput)as T
	where T.end_time<=$eeinput";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	// output data of each row
	echo "<div class='container-fluid' style='font-size: 18px;'>";
		while($row =mysqli_fetch_assoc($result)){
			echo"<div> Event ID: ".$row['event_id']."</div> 
				<div> Event title: ".$row['title']."</div> 
				<div> Event description: ".$row['description']."</div> 
				<div> Start Time: ".$row['start_time']."</div> 
				<div> End Time: ".$row['end_time']."</div>
				<div> Group ID: ".$row['group_id']."</div> 
				<div> Location Name: ".$row['lname']."</div> 
				<div> Location Zipcode: ".$row['zip']."</div> <br>";
		}
	echo"</div>";
	}
	else {
	echo "0 results";
	}
	$conn->close();
?>
<div> <input type="button" value="Go Back" class="button_active" onclick="location.href='sortEvents2.php';"> </div>
</body>
</html>