<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if ($user->is_login()) {
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
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
			case "login":
				require_once "login.php";
				break;
			case "logout":
				require_once "logout.php";
				break;
			}
		}
		require_once "guest.php";
	}
?>
