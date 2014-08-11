<?php
	if (!defined("IN_SCRS")) exit();
	$exam = array("topicname" => $_POST['title'], "comment" => $_POST['desc']);
	$result = $user->add_topic($exam);
	if ($result != false) {
		$length = count($_POST['point_title']);
		for ($i = 0; $i < $length; $i++) {
			$item = array(
				"topic_id" => $result,
				"itemname" => $_POST['point_title'][$i],
				"maxscore" => $_POST['point_score'][$i],
				"comment" => $_POST['point_desc'][$i]
			);
			$user->add_item($item);
		}
		relocate("?action=manexam");
	}
	else {
		echo "<div id='content'>";
		echo "<h4>添加过程中发生了错误，请修改后再提交。</h4>";
		echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
		echo "</div>";
	}
?>