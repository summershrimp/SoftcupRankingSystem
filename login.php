<?php
	require_once './includes/init.inc.php';
	if ($user->login($_POST['username'],$_POST['password'])) {
		relocate("?");
	}
?>
