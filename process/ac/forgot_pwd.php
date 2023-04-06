<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
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
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'e1741064@bit.mrt.ac.lk';
					$mail->Password = 'Windows8.1';
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
					$mail->Port = 465;

					$mail->setFrom('e1741064@bit.mrt.ac.lk', 'Feed the Need');
					$mail->addAddress($email, $name);

					$mail->isHTML(true);
					$mail->Subject = 'Forgot your password?';
					$mail->Body = '
					<div>
						<p>Hi '.$name.'!</p>
						<p>Trouble signing in?</p>
						<p>Please click <a href="http://localhost/ftn/process/ac/reset_link.php?token='.$verification_token.'">here</a> to reset your password.</p>
						<p>If you have any questions in the meantime please write an <a href="mailto:e1741064@bit.mrt.ac.lk">email</a> or <a href="tel:+94771878984">call</a> us.</p>
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