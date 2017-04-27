<?php
	if(isset($_POST['submit'])) {
		$startdate = $_POST['from'];
		$endDate = $_POST['to'];

		

		echo $startdate.' '.$endDate;
	}
?>