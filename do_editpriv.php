<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	$arr = array();
	foreach ($_POST as $key => $value) {
		$t = explode("-", $key);
		$arr[$t[1]][$t[0]] = 1;
	}
	foreach ($arr as $key => $value) {
		$user->change_privilege($key, $value);
	}
	echo "<script>alert('修改成功！')</script>";
	relocate("?action=privilege");
?>