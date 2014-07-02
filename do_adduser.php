<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	$result = true;
	for ($i = 0; $i < count($_POST['name']); $i++) { 
		$tuser = array(
			"username" => $_POST['name'],
			"role_id" => $_POST['type'],
			"sex" => $_POST['sex'],
			"realname" => $_POST['realname'],
			"phone" => $_POST['phone'],
			"comment" => $_POST['comment']
		);
		if ($user->add_user($tuser) == false) {
			$result = false;
			break;
		}
	}
	if ($result != false) {
		relocate("?action=manuser");
	}
	else {
		echo "<div id='content'>";
		echo "<h4>添加过程中发生了错误，请修改后再提交。</h4>";
		echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
		echo "</div>";
	}
?>