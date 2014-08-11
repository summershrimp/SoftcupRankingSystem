<?php
	if (!defined("IN_SCRS")) exit();
	$user_list = $user->get_all_users_no_admin();
	$exam_list = get_all_topics();
	$privilege = $user->get_all_privilege();
?>
<script>
	window.resizeTo(window.screen.availWidth,window.screen.availHeight);
	window.moveTo(0,0);
</script>
<style>
	#main {
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		position: absolute;
		overflow: auto;
	}
</style>
<div id="main">
	<h3 style="text-align:center">权限管理</h3>
	<h4 style="text-align:center">横向为题目，纵向为评委，打勾为有权限。</h4>
	<form action="?action=do_editpriv" method="post" style="text-align:center">
		<table class="single">
			<tr>
				<td></td>
				<?php
					foreach ($user_list as $e) {
						echo "<td style='padding:0 5px'><span>" . $e['realname'] . "</span></td>";
					}
				?>
			</tr>
			<?php
				foreach ($exam_list as $e) {
					echo "<tr>";
					echo "<td><span>" . $e['topicname'] . "</span></td>";
					foreach ($user_list as $f) {
						$checked = isset($privilege[$e['topic_id']][$f['user_id']]) ? "checked='checked'" : "";
						echo "<td><input type='checkbox' name='" . $e['topic_id'] . "-" . $f['user_id'] . "'" . $checked . " /></td>";
					}
					echo "</tr>";
				}
			?>
		</table>
		<input class="button" type="submit" value="提交" />
		<input class="button" type="reset" value="撤销" />
		<input class="button close" type="button" value="关闭" onclick="window.close()" />
	</form>
</div>