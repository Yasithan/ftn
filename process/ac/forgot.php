<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
	//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

	<title>Forgot Password?</title>
	<link rel="stylesheet" type="text/css" href="/ftn/assets/css/styles.css"/>
	<link rel="icon" href="/ftn/assets/images/FTN-Logo.ico">
</head>
<body>

	<!--Header-->
	<header>
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/navigation.php'); ?>
	</header>

	<!--Password reset form-->
	<div class="forgot_div">
		<div class="forgot_img">
			<img src="/ftn/assets/images/shareRP.jpg" class="img-fluid" alt="Image">
		</div>
		<div class="forgot_container">
			<div id="alert" class="alert" style="display: none;"></div>
			<?php 
				if (isset($_SESSION['message'])) {
					echo '<div id="alert" class="alert alert-danger text-center">' . $_SESSION['message'] . '</div>';
					unset($_SESSION['message']);
				}
			?>
			<h2>Forgot password?</h2>
			<p>Please enter your email address and we'll send you a password reset link.</p>
			<form action="" id="forgot_form" method="post">
			<div class="form-floating mb-3">
				<input name="email" id="email" type="email" class="form-control" placeholder="name@example.com">
				<label for="email">Email address</label>
				<div class="invalid-feedback" id="email-error"></div>
			</div>
			<button type="submit" id="submit" class="btn btn-primary d-grid gap-2 col-4 mx-auto">Send email</button>
			</form>
		</div>
	</div>
	<!--Footer-->
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/footer.php') ?>
	<script src="/ftn/assets/js/javascript.js"></script>
</body>
</html>