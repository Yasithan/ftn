<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	
	if (isset($_GET['token'])) {
		$token = $_GET["token"];
		$query = "SELECT * FROM users WHERE verification_token = '$token'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$name = $row['name'];
			$user_id = $row['user_id'];
			setcookie('reset', $user_id, time() + 3600, '/');
		}
	}
	if (!isset($_GET['token']) || mysqli_num_rows($result) != 1) {
		setcookie('reset', 'Invalid reset link.', time() + 3600 , '/');
		header('Location: forgot.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

	<title>Reset password</title>
	<link rel="icon" href="/ftn/assets/images/FTN-Logo.ico">
	<link rel="stylesheet" type="text/css" href="/ftn/assets/css/styles.css"/>
</head>
<body>

	<!--Header-->
	<header>
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/navigation.php'); ?>
	</header>

	<!--Password change form-->
	<div class="forgot_div">
		<div class="reset_img">
			<img src="/ftn/assets/images/shareRP.jpg" class="img-fluid" alt="Image">
		</div>
		<div class="forgot_container">
			<div id="alert" class="alert" style="display: none;"></div>
			<h2>Reset password</h2>
			<?php echo "Hi " . $name; ?>
			<p>Please create a new password for your account.</p>
			<form action="" id="reset_form" method="post">
				<div class="form-floating mb-3">
					<input name="password" id="password" type="password" class="form-control" placeholder="Password">
					<label for="password">Password</label>
					<div class="invalid-feedback" id="password-error"></div>
				</div>
				<div class="form-floating mb-3">
					<input name="repeat_pwd" id="repeat_pwd" type="password" class="form-control" placeholder="Confirm password">
					<label for="repeat_pwd">Confirm password</label>
					<div class="invalid-feedback" id="repeat_pwd-error"></div>
				</div>
				<button type="submit" id="submit" class="btn btn-primary d-grid gap-2 col-6 mx-auto">Reset password</button>
			</form>
		</div>
	</div>	
	<!--Footer-->
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/footer.php') ?>
	<script src="/ftn/assets/js/javascript.js"></script>
</body>
</html>