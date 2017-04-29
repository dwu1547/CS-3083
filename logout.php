<?php
	session_start();
	if($_SESSION['user']) {
		echo "You have logged out";
		session_unset();
		session_destroy();
		header("refresh:2; url=main.php");
	}
	else
		header("refresh:2; url=main.php");
?>