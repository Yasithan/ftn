<?php
	session_start();
	if (isset($_SESSION['SESSION_EMAIL'])) {
		if ($_SESSION['USERTYPE']=="Business") {
			header("Location: create.php");
		} elseif ($_SESSION['USERTYPE']=="Charity") {
			header("Location: available.php");
		} elseif ($_SESSION['USERTYPE']=="Volunteer") {
			header("Location: claimed.php");
		}
		die();
	}
?>