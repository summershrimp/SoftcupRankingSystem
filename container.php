<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if ($user->is_login()) {
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
			case "logout":
				require_once "logout.php";
				exit();
			case "addexam":
				require_once "title.php";
				require_once "addexam.php";
				exit();
			case "addteam":
				require_once "title.php";
				require_once "addteam.php";
				exit();
			case "adduser":
				require_once "title.php";
				require_once "adduser.php";
				exit();
			case "addpoint":
				require_once "title.php";
				require_once "addpoint.php";
				exit();
			}
		}
		require_once "title.php";
		if (isset($_GET['team'])) {
			require_once "team.php";
		}
		else if (isset($_GET['exam'])) {
			require_once "exam.php";
		}
		else if ($user->is_admin()) {
			require_once "admin.php";
		}
		else {
			require_once "logged.php";
		}
	}
	else {
		if (isset($_GET['action']) && $_GET['action'] == "login") {
			require_once "login.php";
			exit();
		}
		require_once "guest.php";
	}
?>
