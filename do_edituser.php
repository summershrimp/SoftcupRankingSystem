<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$user_list = array(
		"username" => $_POST['username'],
		"role_id" => $_POST['type'],
		"sex" => $_POST['sex'],
		"realname" => $_POST['realname'],
		"phone" => $_POST['phone'],
		"comment" => $_POST['comment']
	);
	$user->change_user($_GET['id'], $user_list);
	relocate("?action=manuser");
?>