<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['exam'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$a = get_collects($_GET['exam']);
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=statics'" />
	<h3><?php $tt = get_topic_by_id($exam); echo $tt['topicname']; ?></h3>
	<table>
		<tr>
			<th>队名</th><th>分数</th>
			<?php
				foreach ($a['users'] as $id => $data) {
					echo "<th>" . $data['realname'] . "</th>";
				}
			?>
		</tr>
		<?php
		foreach ($a['contents'] as $team_id => $data) {
			echo "<tr>";
			echo "<td>" . $data['teamname'] . "</td>";
			echo "<td>" . (($data['avescore'] == -1) ? "-" : $data['avescore']) . "</td>";
			foreach ($data['scores'] as $user_id => $score) {
				if ($score == -1) echo "<td>-</td>";
				else echo "<td class='click' onclick=\"window.open('?action=print&exam=" . $_GET['exam'] . "&team=" . $team_id . "&user=" . $user_id . "')\">" . $score . "</td></a>";
			}
			echo "</tr>";
		}
		?>
	</table>
</div>