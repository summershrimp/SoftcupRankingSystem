<?php
	if (!defined("IN_SCRS")) exit();
	$result = true;
	for ($i = 0; $i < count($_POST['name']); $i++) {
		$salt = rand(1000, 9999);
		$tuser = array(
			"username" => $_POST['name'][$i],
			"password" => md5(md5($_POST['password'][$i]).$salt),
			"salt" => $salt,
			"role_id" => $_POST['type'][$i],
			"sex" => $_POST['sex'][$i],
			"isadmin" => $_POST['is_admin'][$i],
			"realname" => $_POST['realname'][$i],
			"phone" => $_POST['phone'][$i],
			"comment" => $_POST['comment'][$i]
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