<?php
	session_start();
	if($_SESSION['user']) {
		echo "You have logged out";
		session_unset();
		header("refresh:2; url=main.html");
	}
	else
		header("refresh:2; url=main.html");
?>