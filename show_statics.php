<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['exam'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$a = get_collects($_GET['exam']);
	$b = NULL;
	foreach ($a as $t) {
		$b = $t['scores'];
		break;
	}
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=statics'" />
	<h3>评分表</h3>
	<table>
		<tr>
			<th>队名</th><th>分数</th>
			<?php
				if ($b != NULL) {
					foreach ($b as $id => $score) {
						echo "<th>" . get_user_realname_by_id($id) . "</th>";
					}
				}
			?>
		</tr>
		<?php
		foreach ($a as $team_id => $b) {
			echo "<tr>";
			echo "<td>" . $b['teamname'] . "</td>";
			echo "<td>" . $b['ave'] . "</td>";
			foreach ($b['scores'] as $user => $score) {
				echo "<td class='click' onclick=\"window.open('?action=print&exam=" . $_GET['exam'] . "&team=" . $team_id . "&user=" . $user . "')\">" . $score . "</td></a>";
			}
			echo "</tr>";
		}
		?>
	</table>
</div>