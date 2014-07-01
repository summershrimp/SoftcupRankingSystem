<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script src="js/conf.js"></script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<input class="button" type="button" value="添加新队伍" onclick="window.location='?action=addteam'" />
	<h3>队伍列表</h3>
	<form action="?action=delteam" method="post">
		<table>
			<tr><!--<th>#</th>--><th>操作</th><th>队伍</th><th>描述</th><th>选题</th></tr>
			<?php
				$team_list = get_all_teams();
				foreach ($team_list as $e) {
					$a = get_topic_by_id($e['topic_id']);
					echo "<tr>";
					//echo "<td><input type='checkbox' name='chk[]' value='" . $e['team_id'] . "' /></td>";
					echo "<td class='click warning' onclick=\"conf('?action=do_delteam&id=" . $e['team_id'] . "','确定要删除这条记录吗？')\">删除</td>";
					echo "<td class='click' onclick=\"window.location.href='?action=editteam&id=" . $e['team_id'] . "'\">" . $e['teamname'] . "</td>";
					echo "<td>" . $e['comment'] . "</td>";
					echo "<td>" . $a['topicname'] . "</td>";
					echo "</tr>";
				}
			?>
		</table>
		<!--<input class="button delete" type="submit" value="批量删除" />-->
	</form>
</div>