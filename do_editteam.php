<?php
	if (!defined("IN_SCRS")) exit();
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$team_list = array(
		"teamname" => $_POST['title'],
		"comment" => $_POST['desc'],
		"topic_id" => $_POST['exam']
	);
	$user->change_team($_GET['id'], $team_list);
	relocate("?action=manteam");
?>