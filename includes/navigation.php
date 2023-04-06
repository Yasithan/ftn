<?php
	if (!isset($_SESSION['SESSION_EMAIL'])) {
?>
		<nav class="navbar navbar-expand-lg bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="/ftn/index.html">
				<img src="/ftn/assets/images/FTN-Logo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
				Feed the Need
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="/ftn/process/ac/sign_in.php">Sign in</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/ftn/process/ac/sign_up.php">Sign up</a>
					</li>
				</ul>
				<span class="navbar-text">
					More food? Share it!
				</span>
			</div>
		</div>
	</nav>
<?php
	} else {
	?>
		<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
			<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="/ftn/index.html	">
				<img src="/ftn/assets/images/FTN-Logo.jpg" alt="Logo" class="d-inline-block align-text-top" width="30" height="24">
				Feed the Need
			</a>
			<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="navbar-nav">
				<div class="nav-item text-nowrap">
					<a class="nav-link px-3" href="/ftn/process/ac/logout.php">Sign out</a>
				</div>
			</div>
		</header>
	<?php
	}
?>