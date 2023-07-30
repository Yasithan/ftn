<?php
	session_start();

	include 'access_rules.php';

	if (isset($_SESSION['role'])) {
		$role = $_SESSION['role'];
		$allowedPages = $accessRules[$role];

		$currentPage = ($_SERVER['PHP_SELF']);

		if (!in_array($currentPage, $allowedPages)) {
			if ($role == 1) {
				header("Location: /ftn/process/donation/create.php");
			} elseif ($role == 2) {
				header("Location: /ftn/process/donation/available.php");
			}
		}
	}	elseif (!isset($_SESSION['role']) && basename($_SERVER['PHP_SELF']) != 'sign_in.php') {
		header("Location: /ftn/process/ac/sign_in.php");
		exit();
	}

	
?>