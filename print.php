<?php
	if (!defined("IN_SCRS")) exit();
	if (isset($_GET['team']) && isset($_GET['exam']) && isset($_GET['user'])) {
		$team = $_GET['team'];
		$exam = $_GET['exam'];
		$userid = $_GET['user'];
	}
	else {
		die();
	}
?>
<style>
	* {
		font-family: "Simsun";
	}
	body {
		background: none;
		font-size: 1.1em;
		overflow: auto !important;
	}
	h2, pre {
		text-align: center;
		line-height: 42px;
		font-family: "SimHei";
	}
	#container {
		width: 90%;
		margin: 0 auto;
	}
	table {
		width: 100%;
		line-height: 24px;
		border: 1px solid #000;
		border-spacing: 0;
		border-collapse: collapse;
		text-align: center;
		page-break-after: auto;
		margin: 0;
	}
	.header {
		color: #FFF;
		background: rgb(33, 88, 104);
		text-align: center;
		font-weight: bold;
	}
	table td, table th {
		border: 1px solid #000;
		background: #FFF;
	}
	#nav {
		border: none;
	}
	#nav tr, #nav tr:hover {
		background: none !important;
	}
	#nav td {
		width: 33.333333%;
		border: none;
	}
	.em {
		background: rgb(251, 212, 180);
		font-weight: bold;
	}
</style>
<script>
	window.resizeTo(window.screen.availWidth,window.screen.availHeight);
	window.moveTo(0,0);
</script>
<h2><?php echo $site_name; ?></h2>
<h2><pre>评   审   表</pre></h2>
<table id="nav">
	<tr>
		<td style="text-align:left">评审日期：<?php echo date("Y-m-d"); ?></td>
		<td style="text-align:center">队伍编号（必填）：<?php $a=get_team_by_id($team); echo $a['team_no']; ?></td>
		<td style="text-align:right">评审人：<?php $a=$user->get_user_by_id($userid); echo $a['realname']; ?></td>
	</tr>
</table>
<table style="margin-top:20px">
	<tr><td class="header" colspan="4">作品信息</td></tr>
	<tr>
		<th width="20%">题目编号</th>
		<td width="30%"><?php $a=get_topic_by_id($exam); echo $a['topicname']; ?></td>
		<th width="20%">团队名称</th>
		<td width="30%"><?php $a=get_team_by_id($team); echo $a['teamname']; ?></td>
	</tr>
</table>
<table style="margin-top:-1px">
	<tr><td class="header" colspan="4">评审信息</td></tr>
	<tr>
		<th width="56%" class="em">评审要点</th>
		<th width="22%">满分分值</th>
		<th width="22%">实际得分</th>
	</tr>
</table>
<?php
	$temps = $user->get_any_team_scores($userid, $team);
	$scores=Array();
	foreach ($temps as $u) {
		$scores[$u['item_id']] = $u['score'];
	}
	$items = get_topic_items($exam);
	$items = array_sort($items, 'item_id');
	foreach ($items as $i) {
		if (!isset($scores[$i['item_id']])) $scores[$i['item_id']] = 0;
		echo "<table style='margin-top:-1px'>";
		echo "<tr>";
		echo "<td width=\"56%\">" . $i['itemname'] . "<br />" . $i['comment'] . "</td>";
		echo "<td width=\"22%\">" . (($i['maxscore'] == 0) ? "" : $i['maxscore']) . "</td>";
		echo "<td width=\"22%\">" . (($i['maxscore'] == 0) ? "" : $scores[$i['item_id']]) . "</td>";
		echo "</tr>";
		echo "</table>\n";
	}
?>
	<table style="margin-top:-1px"><tr><td class="em" width="56%">评审意见及特殊说明</td><td class="em" width="22%">总计</td><td width="22%">
	<?php print_r($user->get_any_team_total_scores($userid, $team)); ?></td></tr></table>
	<table style="margin-top:-1px;margin-bottom:30px"><tr style="line-height:96px"><td width="56%"><?php echo $user->get_feedback_by_id($userid, $team); ?></td><td class="em" width="22%">评审人</td><td width="22%"></td></tr></table>
</table>
<script>window.print();</script>
