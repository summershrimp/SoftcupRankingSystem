<?php
	if (!defined("IN_SCRS")) exit();
	if (!isset($_GET['exam'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$a = get_teams($_GET['exam']);
	$scores = get_collects_by_user($_GET['user'], $_GET['exam']);
	$exam = get_topic_by_id($_GET['exam']);
	$users = $user->get_user_by_id($_GET['user']);
?>
<style>
	body {
		overflow: auto !important;
	}
	table tr:nth-child(even) {
		background: #E6E6E6;
	}
	table tr:nth-child(odd) {
		background: #F3F3F3;
	}
	#main {
		position: relative;
	}
</style>
<div id="main">
	<div style="text-align:center">
		<h3><?php echo $site_name; ?>评分确认表</h3>
	</div>
	<table class="single">
		<thead>
			<tr>
				<th colspan="5">
					<span style="float:left">赛题：<?php echo $exam['topicname']; ?></span>
					<span style="float:right">评审教师：<?php echo $users['realname']; ?></span>
				</th>
			</tr>
			<tr><th>序号</th><th>队伍编号</th><th>队伍名</th><th>平均分</th><th>备注</th></tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($a as $value) {
				echo "<tr>";
				echo "<td>" . $i . "</td>";
				echo "<td>" . $value['team_no'] . "</td>";
				echo "<td>" . $value['teamname'] . "</td>";
				echo "<td>" . (!isset($scores[$value['team_id']])  ? "-" : $scores[$value['team_id']]) . "</td>";
				echo "<td> </td>";
				echo "</tr>";
				$i++;
			}
			?>
		</tbody>
		<tfoot>
			<tr align="right">
				<td colspan="5">
					<div style="line-height:40px;">签字：<span style="border-bottom:1px solid #000;width:150px;height:25px;display:inline-block;vertical-align:middle"></span></div>
					<div><?php echo date('Y 年 m 月 d 日'); ?></div>
				</td>
			</tr>
			<tr align="right">
			</tr>
		</tfoot>
	</table>
	<h3 class="close">
		<input class="button" type="button" value="打印" onclick="print()">
		<input class="button" type="button" value="关闭" onclick="close()">
	</h3>
</div>