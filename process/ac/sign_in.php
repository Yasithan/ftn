<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="/ftn/assets/css/styles.css"/>
	<link rel="icon" href="/ftn/assets/images/FTN-Logo.ico">
</head>
	<body>

		<!--Header-->
		<header>
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/navigation.php'); ?>
		</header>

		<!--Login Form-->
		<div class="login_div" id="login_div">
			<div class="login_img">
				<img src="/ftn/assets/images/login_img.jpg" class="img-fluid">
			</div>
			<div class="login_container">
				<?php
					if (isset($_SESSION['message'])) {
						echo '<div id="alert" class="alert alert-info text-center">' . $_SESSION['message'] . '</div>';
						unset($_SESSION['message']);
					}
				?>
				<div id="alert" class="alert" style="display: none;"></div>
				<form id="login_form" action="" method="post">
					<h1 class="display-5">Welcome!</h1>
					
					<p class="h5">Sign in to your account.</p>

						<div class="form-floating mb-3">
							<input name="email" id="email" type="email" class="form-control" placeholder="name@example.com">
							<label for="email">Email address</label>
							<div class="invalid-feedback" id="email-error"></div>
						</div>
						<div class="form-floating">
							<input name="password" id="password" type="password" class="form-control" placeholder="Password">
							<label for="password">Password</label>
							<div class="invalid-feedback" id="password-error"></div>
						</div>
					
					<button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary d-grid gap-2 col-4 mx-auto">Sign in</button><br>
				</form>
				<a href="/ftn/process/ac/forgot.php">Forgot your password?</a>
				<a href="/ftn/process/ac/sign_up.php">Not registered?</a>
			</div>
		</div>

		<!--Footer-->
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/footer.php') ?>
		<script src="/ftn/assets/js/javascript.js"></script>
	</body>
</html>