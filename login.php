<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	require_once './includes/init.inc.php';
	if ($user->login($_POST['username'],$_POST['password'])) {
		relocate("?");
	}
	else {
		echo "<script>";
		echo "alert('用户名或密码错误！');";
		echo "window.history.go(-1);";
		echo "</script>";
	}
?>
