<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$tuser = $user->get_user_by_id($_GET['id']);
	$salt = $tuser['salt'];
	$user_list = array(
		"role_id" => $_POST['type'],
		"sex" => $_POST['sex'],
		"isadmin" => $_POST['is_admin'],
		"realname" => $_POST['realname'],
		"phone" => $_POST['phone'],
		"comment" => $_POST['comment']
	);
	if (isset($_POST['password']) && $_POST['password'] != "") {
		$user_list['password'] = ($salt == NULL) ? md5($_POST['password']) : md5(md5($_POST['password']).$salt);
	}
	$user->change_user($_GET['id'], $user_list);
	relocate("?action=manuser");
?>