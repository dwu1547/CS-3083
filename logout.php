<?php
	session_start();
	if($_SESSION['user']) {
		echo "You have logged out";
		session_unset();
		header("Location: main.html");
	}
?>