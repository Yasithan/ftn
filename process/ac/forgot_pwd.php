<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require ($_SERVER['DOCUMENT_ROOT']) . '/ftn/vendor/autoload.php';
	if (isset($_POST['email'])) {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$verification_token = bin2hex(random_bytes(32));

		$query = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$name = $row["name"];
			$update = mysqli_query($conn, "UPDATE users SET verification_token='$verification_token' WHERE email='$email'");
			if ($update) {
				$mail = new PHPMailer(true);

				try {
					$mail->SMTPDebug = 0;
					$mail->isSMTP();
					$mail->Host = 'smtp.office365.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'feedtheneed.lk@hotmail.com';
					$mail->Password = 'proFTNlk007$$';
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Port = 587;

					$mail->setFrom('feedtheneed.lk@hotmail.com', 'Feed the Need');
					$mail->addAddress($email, $name);

					$mail->isHTML(true);
					$mail->Subject = 'Forgot your password?';
					$mail->Body = '
					<div>
						<p>Hi '.$name.'!</p>
						<p>Trouble signing in?</p>
						<p>Please click <a href="http://localhost/ftn/process/ac/reset.php?token='.$verification_token.'">here</a> to reset your password.</p>
						<p>If you have any questions in the meantime please write an <a href="mailto:feedtheneed.lk@hotmail.com">email</a> or <a href="tel:+94771878984">call</a> us.</p>
					</div>';

					$mail->send();
					$response = array(
						"success" => true,
						"message" => "Email sent with the instructions."
					);
				} catch (Exception $e) {
					$response = array(
						"success" => false,
						"message" => "Failed to send the email."
					);
				}
			} else {
				$response = array(
					"success" => false,
					"message" => "Failed to update the token."
				);
			}
		} else {
			$response = array(
				"success" => false,
				"message" => "Invalid email address."
			);
		}
		echo json_encode($response);
	}
?>