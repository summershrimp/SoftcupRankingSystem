<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (isset($_GET['team']) && isset($_GET['exam'])) {
		$team = $_GET['team'];
		$exam = $_GET['exam'];
	}
	else {
		die("<h1>题目编号或队伍编号不正确！</h1>");
	}
?>
<style>
	body {
		background: none;
	}
	h2 {
		text-align: center;
		line-height: 42px;
	}
	#container {
		width: 90%;
		margin: 0 auto;
	}
	table {
		width: 100%;
		line-height: 32px;
		border: 1px solid #000;
		border-spacing: 0;
		border-collapse: collapse;
		font-size: 1.1em;
		text-align: center;
		page-break-after: auto;
	}
	.header {
		color: #FFF;
		background: rgb(33, 88, 104);
		text-align: center;
		font-weight: bold;
	}
	td, th {
		border: 1px solid #000;
	}
	.em {
		background: rgb(251, 212, 180);
		font-weight: bold;
	}
</style>
<h2>第三届“中国软件杯”大学生软件设计大赛</h2>
<h2><pre>评   审   表</pre></h2>
<span>评审日期：</span><span style="margin-left:40%">队伍编号（必填）：</span>
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
	$temps = $user->get_team_scores($team);
	$scores=Array();
	foreach ($temps as $u) {
		$scores[$u['item_id']] = $u['score'];
	}
	$items = get_topic_items($exam);
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
	<table style="margin-top:-1px"><tr><td class="em" width="56%">评审意见特殊说明</td><td class="em" width="22%">总计</td><td width="22%"></td></tr></table>
	<table style="margin-top:-1px"><tr style="line-height:96px"><td width="56%"></td><td class="em" width="22%">评审人</td><td width="22%"></td></tr></table>
</table>