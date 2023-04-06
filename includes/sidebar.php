<?php
	if (isset($_SESSION['SESSION_EMAIL'])) {
		?>
		<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="">
			<div class="position-sticky pt-3 sidebar-sticky">
				<div class="container">
					<img src="/ftn/assets/images/profile.png" alt="Profile image" class="rounded-circle img-fluid">
					<p class="lead">Hi, <?php echo $username ?> </p>
				</div>
				<ul class="nav flex-column">
		<?php 
		if ($_SESSION['USERTYPE'] == "Business") {
			?>
			<li class="nav-item">
				<a class="nav-link" href="create.php">
					Donate surplus food
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="mydonations.php">
					My donations
				</a>
			</li>
		<?php 
		} elseif ($_SESSION['USERTYPE'] === "Charity") {
		?>
				<li class="nav-item">
					<a class="nav-link" href="available.php">
						Available surplus food
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						My claims
					</a>
				</li>
		<?php
		} elseif ($_SESSION['USERTYPE'] === "Volunteer") {
		?>
				<li class="nav-item">
					<a class="nav-link" href="claimed.php">
						Food donation claims
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						Delivered
					</a>
				</li>
		<?php
		} elseif ($_SESSION['USERTYPE'] === "Admin") {
		?>
				<li class="nav-item">
					<a class="nav-link" href="donations.php">
						Donations
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="users.php">
						Users
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="items.php">
						Items
					</a>
				</li>
		<?php
		}
	}
?>
					<li class="nav-item">
						<a class="nav-link" href="changepassword.php">
							Settings
						</a>
					</li>
				</ul>
			</div>
		</nav>