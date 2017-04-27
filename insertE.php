<html>
<body>
<?php
	require('connect.php');
	# Check if user is signed in or not
	if(!isset($_SESSION['user'])) {
		echo "User is not signed in";
		header("refresh:2; url=main.html");
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
	echo"START DATE:";
	$totstart =($syear.$smonth.$sdate);
	echo $totstart,"<br>";
	echo"END DATE:";
	$totend =($eyear.$emonth.$edate);
	echo $totend,"<br>";

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
	echo "<table>";
		while($row =mysqli_fetch_assoc($result)){
			echo"<tr><td>" , $row['event_id'] , "</td><td>".$row['title'],"</td><td>",$row['description'],
			"</td><td>",$row['start_time'],"</td><td>",$row['end_time'],"</td><td>",$row['group_id'],
			"</td><td>",$row['lname'],"</td><td>",$row['zip'],"</td></tr>";
		}
	echo"</table>";
	}
	else {
	echo "0 results";
	}
	$conn->close();
?>
</body>
</html>