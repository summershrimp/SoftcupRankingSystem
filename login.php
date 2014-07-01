<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	require_once './includes/init.inc.php';
	if ($user->login($_POST['username'],$_POST['password'])) {
		relocate("?");
	}
?>
