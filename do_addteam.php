<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	$result = true;
	for ($i = 0; $i < count($_POST['name']); $i++) { 
		$team = array(
			"teamname" => $_POST['name'][$i],
			"comment" => $_POST['desc'][$i],
			"topic_id" => $_POST['exam'][$i]
		);
		if ($user->add_team($team) == false) {
			$result = false;
			break;
		}
	}
	if ($result != false) {
		relocate("?action=manteam");
	}
	else {
		echo "<div id='content'>";
		echo "<h4>添加过程中发生了错误，请修改后再提交。</h4>";
		echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
		echo "</div>";
	}
?>