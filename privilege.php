<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	$user_list = $user->get_all_users_no_admin();
	$exam_list = get_all_topics();
	$privilege = $user->get_all_privilege();
?>
<div id="content">
	<h3>权限管理</h3>
	<table>
		<tr>
			<td></td>
			<?php
				foreach ($user_list as $e) {
					echo "<td>" . $e['realname'] . "</td>";
				}
			?>
		</tr>
		<?php
			foreach ($exam_list as $e) {
				echo "<tr>";
				echo "<td>" . $e['topicname'] . "</td>";
				foreach ($user_list as $f) {
					$checked = isset($privilege[$e['topic_id']][$f['user_id']]) ? "checked='checked'" : "";
					echo "<td><input type='checkbox' name='" . $e['topic_id'] . "-" . $f['user_id'] . "'" . $checked . " /></td>";
				}
				echo "</tr>";
			}
		?>
	</table>
</div>