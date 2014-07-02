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
		"password" => md5(md5($_POST['password'][$i]).$salt),
		"role_id" => $_POST['type'][$i],
		"sex" => $_POST['sex'][$i],
		"is_admin" => $_POST['is_admin'][$i],
		"realname" => $_POST['realname'][$i],
		"phone" => $_POST['phone'][$i],
		"comment" => $_POST['comment'][$i]
	);
	$user->change_user($_GET['id'], $user_list);
	//relocate("?action=manuser");
?>