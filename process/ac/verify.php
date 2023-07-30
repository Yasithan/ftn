<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';

	$verification_token = $_GET["token"];

	$query = "SELECT * FROM users WHERE verification_token = '$verification_token'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) == 1) {
		$user = mysqli_fetch_assoc($result);

		if ($user['is_verified']) {
			$cookie_value = "verified";
		} else {
			$user_id = $user["user_id"];
			$query = "UPDATE users SET is_verified = 1 WHERE user_id = $user_id";
			mysqli_query($conn, $query);
			$cookie_value = "completed";
		}
	} else {
		$cookie_value = "invalid";
	}

	setcookie('verification_status', $cookie_value, time() + 3600, '/');
	header("Location: sign_in.php");
	exit();
?>