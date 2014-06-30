<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if ($user->is_login()) {
		if (isset($_GET['action']) && $_GET['action'] == "logout") {
			require_once "logout.php";
		}
		require_once "title.php";
		if (isset($_GET['team'])) {
			require_once "team.php";
		}
		else if (isset($_GET['exam'])) {
			require_once "exam.php";
		}
		else {
			require_once "logged.php";
		}
	}
	else {
		if (isset($_GET['action']) && $_GET['action'] == "login") {
			require_once "login.php";
		}
		require_once "guest.php";
	}
?>
