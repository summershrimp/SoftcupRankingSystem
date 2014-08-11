<?php
	if (!defined("IN_SCRS")) exit();
	$user->confirm_all();
	echo "<script>alert('提交成功！')</script>";
	relocate("?");
?>