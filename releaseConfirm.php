<?php
	define("IN_SCRS",true);
	require_once "includes/init.inc.php";
	echo $user->open_confirmed($_GET['id']);
?>