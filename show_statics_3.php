<?php
	if (!defined("IN_SCRS")) exit();
	$list = get_all_topics();
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
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		position: absolute;
		overflow: auto;
	}
</style>
<div id="main">
	<div style="text-align:center">
		<h3>中国软件杯大赛参赛队伍分数汇总表</h3>
	</div>
	<table class="single">
		<thead>
			<tr><th>序号</th><th>赛题</th><th>队伍编号</th><th>队名</th><th>平均分</th><th>备注</th></tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($list as $key => $value) {
				$a = get_collects($value['topic_id']);
				if (isset($a['contents'])) {
					foreach ($a['contents'] as $team_id => $data) {
						echo "<tr>";
						echo "<td>" . $i . "</td>";
						echo "<td>" . $value['topicname'] . "</td>";
						echo "<td>" . $data['team_no'] . "</td>";
						echo "<td>" . $data['teamname'] . "</td>";
						echo "<td>" . (($data['avescore'] == -1) ? "-" : $data['avescore']) . "</td>";
						echo "<td> </td>";
						echo "</tr>";
						$i++;
					}
				}
			}
			?>
		</tbody>
	</table>
	<h3 class="close"><input class="button" type="button" value="关闭" onclick="window.close()" /></h3>
</div>