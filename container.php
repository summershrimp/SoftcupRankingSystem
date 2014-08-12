<?php
	if (!defined("IN_SCRS")) exit();
	// 已登录的场景
	if ($user->is_login()) {
		// 管理员的操作
		if ($user->is_admin()) {
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
				case "addexam":case "addteam":case "adduser":
				case "manexam":case "manteam":case "manuser":
				case "editexam":case "editteam":case "edituser":
				case "delexam":case "delteam":case "deluser":
					require_once "title.php";
					require_once "admin.php";
					require_once $_GET['action'] . ".php";
					break;
				case "do_addexam":case "do_addteam":case "do_adduser":
				case "do_editexam":case "do_editteam":case "do_edituser":
				case "do_delexam":case "do_delteam":case "do_deluser":
				case "do_editpriv":
				case "privilege":
				case "print":
				case "logout":
					require_once $_GET['action'] . ".php";
					break;
				case "statics":
					require_once "title.php";
					require_once "admin.php";
					if (isset($_GET['id'])) {
						switch ($_GET['id']) {
						case 1:case 2:case 3:
							require_once $_GET['action'] . "_" . $_GET['id'] . ".php"; break;
						}
					}
					else {
						require_once $_GET['action'] . ".php";
					}
					break;
				case "show_statics":
					if (isset($_GET['id'])) {
						switch ($_GET['id']) {
						case 1:case 2:case 3:
							require_once $_GET['action'] . "_" . $_GET['id'] . ".php"; break;
						}
					}
					break;
				}
			}
			else {
				require_once "title.php";
				require_once "admin.php";
				require_once "admindef.php";
			}
		}
		// 普通用户的操作
		else {
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
				case "logout":
				case "do_submit":
					require_once $_GET['action'] . ".php";
					break;
				case "post_score":
					require_once "title.php";
					require_once "post_score.php";
				}
			}
			else {
				require_once "title.php";
				if (isset($_GET['team'])) require_once "team.php";
				else if (isset($_GET['exam'])) require_once "exam.php";
				else require_once "logged.php";
			}
		}
	}
	// 未登录的场景
	else {
		if (isset($_GET['action']) && $_GET['action'] == "login") require_once "login.php";
		else require_once "guest.php";
	}
?>
