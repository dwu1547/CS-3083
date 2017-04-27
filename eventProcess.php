<?php
	if(isset($_POST['submit'])) {
		$startdate = $_POST['from'];
		$endDate = $_POST['to'];
		$selgroupID = $_POST['selgroupID'];
		$selLocName = $_POST['selLoc'];		# white space issue 

		# Check for same event ID

		echo $startdate.' '.$endDate;
		echo "group ID: ".$selgroupID;
		echo "location name: ".$selLocName;
		# Check for field errors


		# Check if user is authorized to make new event
		/* $selAuthority = "SELECT * FROM belongs_to WHERE username = '".$_SESSION['user']."' AND authorized = 1";
		$qry = mysqli_query($conn, $selAuthority);
		if($qry && mysqli_num_of_rows($qry) > 0) {
			# Insert new event
		} */
	}
?>