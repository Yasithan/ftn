<?php 
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	if (isset($_POST['password']) && isset($_POST['repeat_pwd'])) {
		$password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
		$repeat_pwd = mysqli_real_escape_string($conn, $_POST['repeat_pwd']);
		if (isset($_COOKIE['reset'])) {
			$user_id = $_COOKIE['reset'];
		}

		if (password_verify($repeat_pwd, $password)) {
			$verification_token = bin2hex(random_bytes(32));
			$reset = mysqli_query($conn, "UPDATE users SET password='$password', verification_token='$verification_token' WHERE user_id='$user_id'");

			if ($reset){
				$response = array(
					"success" => true,
					"message" => "Password reset successfully."
				);
				
			} else {
				$response = array(
					"success" => false,
					"message" => "Unable to update the db"
				);
			}
		} else {
			$response = array(
				"success" => false,
				"message" => "Password and repeat password do not match."
			);
		}
	} else {
		header ("Location: forgot.php");
	}
	echo json_encode($response);
?>