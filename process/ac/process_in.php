<?php
	session_start();
	include ($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/config.php');
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) == 0){
			$response = array(
				"success" => false,
				"message" => "Invalid email address"
			);
		} else {
			$row = mysqli_fetch_assoc($result);
			if (!password_verify($password, $row['password'])) {
				$response = array(
					"success" => false,
					"message" => "Incorrect password"
				);
			} else {
				if (!$row["is_verified"]) {
					$response = array(
						"success" => false,
						"message" => "Please verify your email address"
					);
				} else {
					$_SESSION['email'] = $email;
					$_SESSION['role'] = $row["user_type_id"];
					$_SESSION['name'] = $row["name"];
					$_SESSION['id'] = $row["user_id"];
					$response = array(
						"success" => true,
						"user_type_id" => $row["user_type_id"] 
					);
				}
			}
		}
	}
	echo json_encode($response);
?>