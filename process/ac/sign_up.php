<?php 
	include ($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/config.php');
	include ($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

	<title>Sign up</title>
	<link rel="icon" href="/ftn/assets/images/FTN-Logo.ico">
	<link rel="stylesheet" type="text/css" href="/ftn/assets/css/styles.css"/>
</head>
<body>
	<!--Header-->
	<header> <?php include($_SERVER['DOCUMENT_ROOT'] . '/ftn/includes/navigation.php'); ?> </header>

	<!--Contents-->
	<div class="div_container">
		<div class="reg_img">
			<img src="/ftn/assets/images/regBG.jpg" class="img-fluid" alt="">
		</div>

		<!--Form container-->
		<div class="form_container">
			<form action="" method="post" class="reg_form" id="reg_form">
				<div id="alert" class="alert" style="display: none;"></div>

				<!--User role drop down-->
				<div class="user_role">
					<h2>Create an account to get started!</h2>
					<div class="form-floating">
						<select name="user_type" id="user_type" class="form-select mb-2">
							<option value="" selected>Please select your role</option>
							<option value="1">Business</option>
							<option value="2">Charity</option>
							<option value="3">Volunteer</option>
						</select>
						<label for="user_type">I am a </label>
					</div>
					<a href="/ftn/process/ac/sign_in.php">Already have an account?</a>
				</div>
				<!--Form-->
				<div class="reg_container" id="reg_container">
					<!--Role discription-->
					<div id="default" class="data">
						<p>If you are a business that has surplus food that you would like to donate, then please select <strong>Business</strong></p>
						<p>If you are a charity that needs food, then please select <strong>Charity</strong></p>
						<p>If you have free time to join the volunteer organization and help to serve the surplus food, then please select <strong>Volunteer</strong></p>
					</div>
					<div id="common_fields" class="data">
						<h2 id="h2"></h2>
						<h5>Please fill in this form to create an account.</h5>
						
						<div class="form-floating">
							<input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
							<label id="name_label" for="name"></label>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-floating">
									<input type="text" class="form-control" id="building_no" placeholder="Building No." name="building_no" required>
									<label for="building_no">Building No.</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-floating">
									<input type="text" class="form-control" id="street" placeholder="Street" name="street" required>
									<label for="street">Street</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-floating">
									<select name="district" id="district" class="form-select mb-2" required>
										<option value="" selected disabled>Select your district</option>
										<?php
											$result = mysqli_query($conn, "SELECT * FROM districts");
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<option value="' . $row['district_id'] . '">' . $row['district_name'] . '</option>';
											}
										?>
									</select>
									<label for="district">District</label>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-floating">
									<select name="area" id="area" class="form-select mb-2" required>
										<option value="" selected disabled>Select your area</option>
										<?php
											$result = mysqli_query($conn, "SELECT * FROM areas");
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<option class="area-option district-' . $row['district_id'] . '" value="' . $row['area_id'] . '">' . $row['area_name'] . '</option>';
											}
										?>
									</select>
									<label for="area">Area</label>
								</div>
							</div>
						</div>

						<div class="form-floating">
							<input type="text" class="form-control" id="contact_no" placeholder="Contact number" name="contact_no" required>
							<label for="contact_no">Contact number</label>
							<div class="invalid-feedback alert alert-danger" id="contact_no_error">
								Please enter a valid contact number
							</div>
						</div>

						<!--Donor form-->
						<div id="donor_fields">
							<div class="form-floating">
								<select name="donor_type" id="donor_type" class="form-select mb-2">
									<option value="" selected disabled>Select your business type</option>
									<?php
										$result = mysqli_query($conn, "SELECT * FROM donor_type");
										while ($row = mysqli_fetch_assoc($result)) {
											echo '<option value="' . $row['donor_type_id'] . '">' . $row['donor_type_name'] . '</option>';
										}
									?>
								</select>
								<label for="donor_type">Business type</label>
							</div>
						</div>	
						<!--Beneficiary form-->
						<div id="beneficiary_fields">
							<div class="form-floating">
								<select name="beneficiary_type" id="beneficiary_type" class="form-select mb-2" required>
									<option value="" selected disabled>Select your charity organization type</option>
									<?php
										$result = mysqli_query($conn, "SELECT * FROM beneficiary_type");
										while ($row = mysqli_fetch_assoc($result)) {
											echo '<option value="' . $row['beneficiary_type_id'] . '">' . $row['beneficiary_type_name'] . '</option>';
										}
									?>
								</select>
								<label for="beneficiary_type">Charity organization type</label>
							</div>
						</div>

						<!--Common for Donor and Beneficiary-->
						<div id="db_fields">
							<div class="form-floating">
								<input type="text" class="form-control" id="reg_no" placeholder="Registration number" name="reg_no">
								<label for="reg_no">Registration number</label>
							</div>

							<label for="cp"><b>Contact person details</b></label><br>
							<div class="row">
								<div class="col-md-6">
									<div class="form-floating">
										<input type="text" class="form-control" id="cp_name" placeholder="Contact Person Name" name="cp_name">
										<label for="cp_name">Name of the contact person</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating">
										<input type="text" class="form-control" id="cp_phone" placeholder="Phone Number" name="cp_phone">
										<label for="cp_phone">Phone number</label>
										<div class="invalid-feedback alert alert-danger" id="cp_phone_error">
											Please enter a valid phone number
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Volunteer form-->
						<div id="volunteer_fields">
							<div class="form-floating">
								<select name="vol_org" id="vol_org" class="form-select mb-2">
									<option value="" selected disabled>Select the volunteer organization you're registered with</option>
									<?php
										$result = mysqli_query($conn, "SELECT * FROM volunteer_organization");
										while ($row = mysqli_fetch_assoc($result)) {
											echo '<option value="' . $row['vo_id'] . '">' . $row['vo_name'] . '</option>';
										}
									?>
								</select>
								<label for="vol_org">Volunteer organization</label>
							</div>

							<div class="form-floating">
								<select name="transport_mode" id="transport_mode" class="form-select mb-2">
									<option value="" selected disabled>Select your preferred mode of transportation</option>
									<option value="bicycle">Bicycle</option>
									<option value="car">Car</option>
									<option value="motorcycle">Motorcycle</option>
									<option value="public transport">Public transport</option>
									<option value="taxi">Taxi</option>
									<option value="three wheel">Three wheel</option>
								</select>
								<label for="transport_mode">Mode of transportation</label>
							</div>
						</div>

						<!--Common for donor and volunteer-->
						<div id="dv_fields">
							<b><label id="operating_dh" for="operating_dh"></label><br></b>
							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="mon" value="mon">
								<label class="form-check-label" for="mon">Monday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="tue" value="tue">
								<label class="form-check-label" for="tue">Tuesday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="wed" value="wed">
								<label class="form-check-label" for="wed">Wednesday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="thu" value="thu">
								<label class="form-check-label" for="thu">Thursday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="fri" value="fri">
								<label class="form-check-label" for="fri">Friday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="sat" value="sat">
								<label class="form-check-label" for="sat">Saturday</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" name="days[]"type="checkbox" id="sun" value="sun">
								<label class="form-check-label" for="sun">Sunday</label>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-floating" style="margin-bottom: 5px;">
										<input type="time" class="form-control" id="start_time" placeholder="Start time" name="start_time" required>
										<label id="label_st" for="start_time"></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating" style="margin-bottom: 5px;">
										<input type="time" class="form-control" id="end_time" placeholder="End time" name="end_time" required>
										<label id="label_et" for="end_time"></label>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-floating">
							<input type="email" class="form-control" id="email" placeholder="Email address" name="email" required>
							<label for="email">Email address</label>
							<div class="invalid-feedback alert alert-danger" id="email_error">
								Please enter a valid email address.
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-floating">
									<input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
									<label for="password">Password</label>
									<div class="invalid-feedback alert alert-danger" id="password_error">
										Password should contain at least 6 characters.
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-floating">
									<input type="password" class="form-control" id="repeat_pwd" placeholder="Confirm password" name="repeat_pwd" required>
									<label for="repeat_pwd">Confirm password</label>
									<div class="invalid-feedback alert alert-danger" id="repeat_pwd_error">
										Password and confirm password do not match
									</div>
								</div>
							</div>
						</div>
						<p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

						<button type="submit" id="submit_btn" class="btn btn-primary d-grid gap-2 col-4 mx-auto">Sign up</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!--Footer-->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/ftn/includes/footer.php') ?>
	<script src="/ftn/assets/js/sign_up.js"></script>
</body>
</html>