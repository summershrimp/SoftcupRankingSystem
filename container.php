<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if ($user->is_login()) {
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
			case "logout":
				require_once "logout.php";
				break;
			case "addexam":
			case "addteam":
			case "adduser":
			case "manexam":
			case "manteam":
			case "manuser":
			case "editexam":
			case "editteam":
			case "edituser":
			case "delexam":
			case "delteam":
			case "deluser":
			case "do_addexam":
			case "do_addteam":
			case "do_adduser":
			case "do_editexam":
			case "do_delexam":
			case "statics":
			case "show_statics":
				require_once "title.php";
				require_once "admin.php";
				require_once $_GET['action'] . ".php";
				break;
			case "print":
				if ($user->is_admin()) {
					require_once "print.php";
				}
				else {
					require_once "title.php";
					require_once "logged.php";
				}
			}
		}
		else {
			require_once "title.php";
			if ($user->is_admin()) {
				require_once "admin.php";
			}
			else if (isset($_GET['team'])) {
				require_once "team.php";
			}
			else if (isset($_GET['exam'])) {
				require_once "exam.php";
			}
			else {
				require_once "logged.php";
			}
		}
	}
	else {
		if (isset($_GET['action']) && $_GET['action'] == "login") {
			require_once "login.php";
		}
		else {
			require_once "guest.php";
		}
	}
?>
