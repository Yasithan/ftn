<?php
	include ($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/config.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	

	require ($_SERVER['DOCUMENT_ROOT'] . '/ftn/vendor/autoload.php');

	function insert_user_type ($user_id, $user_type_id, $conn, $email, $name, $verification_token){
		if ($user_type_id == 1) {
			$donor_type_id = mysqli_real_escape_string($conn, $_POST['donor_type']);
			$reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
			$cp_name = mysqli_real_escape_string($conn, $_POST['cp_name']);
			$cp_phone = mysqli_real_escape_string($conn, $_POST['cp_phone']);
			$active_days = implode(",", $_POST['days']);
			$open_time = mysqli_real_escape_string($conn, $_POST['start_time']);
			$close_time = mysqli_real_escape_string($conn, $_POST['end_time']);
			$table_name = "donor";
			$columns = "(user_id, donor_type_id, reg_no, cp_name, cp_phone, active_days, open_time, close_time)";
			$values = "('$user_id', '$donor_type_id', '$reg_no', '$cp_name', '$cp_phone', '$active_days', '$open_time', '$close_time')";
		} elseif ($user_type_id == 2) {
			$beneficiary_type_id = mysqli_real_escape_string($conn, $_POST['beneficiary_type']);
			$reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
			$cp_name = mysqli_real_escape_string($conn, $_POST['cp_name']);
			$cp_phone = mysqli_real_escape_string($conn, $_POST['cp_phone']);
			$table_name = "beneficiary";
			$columns = "(user_id, beneficiary_type_id, reg_no, cp_name, cp_phone)";
			$values = "('$user_id', '$beneficiary_type_id', '$reg_no', '$cp_name', '$cp_phone')";
		} elseif ($user_type_id == 3) {
			$vo_id = mysqli_real_escape_string($conn, $_POST['vol_org']);
			$transport_mode = mysqli_real_escape_string($conn, $_POST['transport_mode']);
			$active_days = implode(",", $_POST['days']);
			$start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
			$end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
			$table_name = "volunteer";
			$columns = "(user_id, vo_id, transport_mode, active_days, start_time, end_time)";
			$values = "('$user_id', '$vo_id', '$transport_mode', '$active_days', '$start_time', '$end_time')";
		}
		$query = "INSERT INTO $table_name $columns VALUES $values";
		if ($conn->query($query) === TRUE) {
			$mail_sent = verification_email($email, $name, $verification_token);
			if ($mail_sent) {
				$response = array(
					"success" => true,
					"message" => "Account created successfully. Please verify your email address."
				);
			} else {
				$response = array(
					"success" => false,
					"message" => "Error sending verification email."
				);
			}
		} else {
			$response = array(
				"success" => false,
				"message" => "Error creating account: " . $conn->error
			);
		}

		return $response;
	}
	function verification_email ($email, $name, $verification_token){
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
			$mail->Subject = 'Thanks for signing up!';
			$mail->Body = '<div>
			<p>Hi '.$name.'!</p>
			<p>Thanks for signing up to our surplus food redistribution platform!</br>
			<p>Simply click <a href="http://localhost/ftn/process/ac/verify.php?token='.$verification_token.'">here</a> to verify your email address.</p>
			<p>If you have any questions in the meantime please write an <a href="mailto:feedtheneed.lk@hotmail.com">email</a> or <a class="text-muted" href="tel:+94771878984">call</a> us.</p></div>';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	$user_type_id = mysqli_real_escape_string($conn, $_POST['user_type']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$building_no = mysqli_real_escape_string($conn, $_POST['building_no']);
	$street = mysqli_real_escape_string($conn, $_POST['street']);
	$district_id = mysqli_real_escape_string($conn, $_POST['district']);
	$area_id = mysqli_real_escape_string($conn, $_POST['area']);
	$phone_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
	$repeat_pwd = mysqli_real_escape_string($conn, $_POST['repeat_pwd']);

	$query = "SELECT * FROM users WHERE email='$email'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		$response = array(
			"success" => false,
			"message" => "Email already exists!"
		);
	} else {
		if (!password_verify($repeat_pwd, $password)) {
			$response = array(
				"success" => false,
				"message" => "Passwords do not match"
			);
		} else {
			$verification_token = bin2hex(random_bytes(32));
			$query = "INSERT INTO users (user_type_id, name, building_no, street, district_id, area_id, phone_no, email, password, verification_token) VALUES ('$user_type_id', '$name', '$building_no', '$street', '$district_id', '$area_id', '$phone_no', '$email', '$password', '$verification_token')";

			if ($conn->query($query) === TRUE) {
				$user_id = $conn->insert_id;
				$response = insert_user_type($user_id, $user_type_id, $conn, $email, $name, $verification_token);
			} else {
				$response = array(
					"success" => false,
					"message" => "Error: " . $conn->error
				);
			}
		}
	}
	echo json_encode($response);
?>