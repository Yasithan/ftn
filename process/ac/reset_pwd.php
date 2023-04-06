<?php 
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
	if (isset($_POST['password']) && isset($_POST['repeat_pwd'])) {
		$password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
		$repeat_pwd = mysqli_real_escape_string($conn, $_POST['repeat_pwd']);
		$user_id = $_SESSION['user_id'];

		if (password_verify($repeat_pwd, $password)) {
			$verification_token = bin2hex(random_bytes(32));
			$reset = mysqli_query($conn, "UPDATE users SET password='$password', verification_token='$verification_token' WHERE user_id='$user_id'");

			if ($reset){
				//$_SESSION['message'] = "Your password reset successfully.";
				//header("Location: sign_in.php");
				$response = array(
					"success" => true,
					"message" => "Password reset successfully."
				);
				session_unset();
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