<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$item = get_topic_items($_GET['id']);
	foreach ($item as $e) {
		$user->delete_item($e['item_id']);
	}
	print_r($_POST);
	$exam = array("topicname" => $_POST['title'], "comment" => $_POST['desc']);
	$user->change_topic($_GET['id'], $exam);
	$length = count($_POST['title']);
	for ($i = 0; $i < $length; $i++) {
		$item = array(
			"topic_id" => $_GET['id'],
			"itemname" => $_POST['point_title'][$i],
			"maxscore" => $_POST['point_score'][$i],
			"comment" => $_POST['point_desc'][$i]
		);
		$user->add_item($item);
	}
	relocate("?action=manexam");
	exit();
	echo "<div id='content'>";
	echo "<h4>编辑过程中发生了错误。</h4>";
	echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
	echo "</div>";
?>