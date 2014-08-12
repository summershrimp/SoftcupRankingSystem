<?php
	if (!defined("IN_SCRS")) exit();
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$result = $user->delete_user($_GET['id']);
	if ($result != false) {
		relocate("?action=manuser");
	}
	else {
		echo "<div id='content'>";
		echo "<h4>删除过程中发生了错误。</h4>";
		echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
		echo "</div>";
	}
?>