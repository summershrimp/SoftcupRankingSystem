<?php
	if (!defined("IN_SCRS")) exit();
	if (!isset($_GET['exam'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$a = get_collects($_GET['exam']);
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
<script src="js/sorttable.js"></script>
<div id="main">
	<div style="text-align:center">
		<h3><?php echo $site_name; ?>分赛题分数统计表</h3>
		<h3>赛题：<?php $tt = get_topic_by_id($exam); echo $tt['topicname']; ?></h3>
		<h4>点按表头排序表格</h4>
	</div>
	<table class="sortable single">
		<thead>
			<tr>
				<th>序号</th><th>队伍编号</th><th>队名</th><th class="sort_numeric">平均分</th>
				<?php
					foreach ($a['users'] as $id => $data) {
						echo "<th class='sort_numeric'>" . $data['realname'] . "</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			if (isset($a['contents'])) {
				$i = 1;
				foreach ($a['contents'] as $team_id => $data) {
					echo "<tr>";
					echo "<td>" . $i . "</td>";
					echo "<td>" . $data['team_no'] . "</td>";
					echo "<td>" . $data['teamname'] . "</td>";
					echo "<td>" . (($data['avescore'] == -1) ? "-" : $data['avescore']) . "</td>";
					if ($data['avescore'] == -1) {
						foreach ($a['users'] as $id => $data) {
							echo "<td></td>";
						}
					}
					else {
						foreach ($data['scores'] as $user_id => $score) {
							if ($score == -1) echo "<td>-</td>";
							else echo "<td class='click' onclick=\"window.open('?action=print&exam=" . $_GET['exam'] . "&team=" . $team_id . "&user=" . $user_id . "','_blank','toolbar=no,menubar=no,location=no,scrollbars=yes,status=no')\">" . $score . "</td></a>";
						}
					}
					echo "</tr>";
					$i++;
				}
			}
			?>
		</tbody>
	</table>
	<h3 class="close"><input class="button" type="button" value="关闭" onclick="window.close()" /></h3>
</div>