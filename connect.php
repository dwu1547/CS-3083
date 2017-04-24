<?php
	$dbname = "cs3083_proj";

	$conn = new mysqli("localhost", "root", "", $dbname);

	if ($conn->connect_error)
	    die("Connection failed: " . $conn->connect_error);

	# echo "Connection success";
?>