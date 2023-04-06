<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
	session_unset();
	if (isset($_GET['token'])) {
		$token = $_GET["token"];
		$query = "SELECT * FROM users WHERE verification_token = '$token'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['name'] = $row['name'];
			header("Location: reset.php");
		} else {
			$_SESSION['message'] = "Invalid password reset link.";
			header("Location: forgot.php");
		}
	} else {
		header("Location: forgot.php");
	}
?>