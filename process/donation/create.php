<?php
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/config.php';
	include ($_SERVER['DOCUMENT_ROOT']) . '/ftn/includes/header.php';
	echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
	if (!isset($_SESSION['email'])) {
		header ("Location: /ftn/process/ac/sign_in.php");
		die();
	} elseif ($_SESSION['USERTYPE'] == "3" ) {
		header("Location: claimed.php");
	}
	$msg = "";
	$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['email']}'");

	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_assoc($query);
		$username = $row['name'];
		$businessid = $row['user_id'];
	}

	if (isset($_POST['submit'])) {
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$foodtype =mysqli_real_escape_string ($conn, implode(', ',$_POST['foodtype']));
		$veg = mysqli_real_escape_string($conn, $_POST['veg']);
		$info = mysqli_real_escape_string($conn, $_POST['info']);
		$pickuptime = mysqli_real_escape_string($conn, $_POST['pickuptime']);

		$sql = "INSERT INTO donations (title, createdby, createddt, foodtype, veg, info, collectdt) VALUES ('{$title}', '{$businessid}', now(), '{$foodtype}', '{$veg}', '{$info}', '{$pickuptime}')";

		$result = mysqli_query($conn, $sql);

		if ($result) {
			$msg = "<div class='alert alert-success'>Your donation posted successfully.</div>";
		}
	}
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

	<title>Create Donation</title>
	<link rel="icon" href="assets/images/FTN-Logo.ico">
	
</head>
<body>
	
	<!--Header-->
	<header>
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/navigation.php'); ?>
	</header>

	<!--Content-->
	<div class="row">

		<!--Sidebar-->
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/sidebar.php'); ?>

		<!--Create donation form-->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
			<h1 class="display-5 m-3">Donate surplus food</h1>
			<?php echo $msg; ?>
			<form class="m-3" method="post">

				<div class="mb-3">
					<label for="title" class="form-label">Title</label>
					<input name="title" type="text" class="form-control" id="title" required>
				</div>
				<div class="mt-2">Type of food</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype1" name="foodtype[]" value="Prepared food">
					<label class="form-check-label" for="foodtype1">Prepared food</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype2" name="foodtype[]" value="Uncooked food items">
					<label class="form-check-label" for="foodtype2">Uncooked food items</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype3" name="foodtype[]" value="Fruits / Vegetables">
					<label class="form-check-label" for="foodtype3">Fruits / Vegetables</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype4" name="foodtype[]" value="Bakery products">
					<label class="form-check-label" for="foodtype4">Bakery products</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype5" name="foodtype[]" value="Dairy products">
					<label class="form-check-label" for="foodtype5">Dairy products</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" id="foodtype6" name="foodtype[]" value="Other">
					<label class="form-check-label" for="foodtype6">Other</label>
				</div>

				<div class="my-3">Vegitarian food?
					<div class="mx-3 form-check form-check-inline">
						<input class="form-check-input" type="radio" name="veg" id="yes" value="Yes" required>
						<label class="form-check-label" for="yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="veg" id="no" value="No">
						<label class="form-check-label" for="no">No</label>
					</div>
				</div>

				<div class="mb-3">
					<label for="info" class="form-label">Additional information</label>
					<textarea name="info" class="form-control" id="info" rows="3" required></textarea>
					<!--<input name="info" type="text" class="form-control" id="info" required>-->
					<p><small>Please provide useful information about your donation. For example; food items, quantity, expiry date, etc.</small></p>
				</div>

				<div class="mb-3">
					<label for="pickuptime" class="form-label">Choose a date and time to collect the food</label>
					<input name="pickuptime" type="datetime-local" class="form-control" id="pickuptime" required>
				</div>

				<button name="submit" type="submit" class="btn btn-primary">Post donation</button>
			</form>
		</main>
	</div>

	<!--Footer-->
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/footer.php') ?>
</body>
</html>