<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['exam'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$a = get_collects($_GET['exam']);
	foreach ($a as $t) {
		$b = $t['scores'];
		break;
	}
?>
<div id="content">
	<table>
		<tr>
			<th>队名</th><th>分数</th>
			<?php
				foreach ($b as $id => $score) {
					echo "<th>" . get_user_realname_by_id($id) . "</th>";
				}
			?>
		</tr>
		<?php
		foreach ($a as $b) {
			echo "<td>" . $b['teamname'] . "</td>";
			echo "<td>" . $b['ave'] . "</td>";
			foreach ($b['scores'] as $key => $score) {
				echo "<td>" . $score . "</td>";
			}
		}
		?>
	</table>
</div>