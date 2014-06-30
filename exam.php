<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>题目</h3>
	<h3>请选择队伍</h3>
	<ul>
	<?php
		$teams = get_teams($exam);
		foreach($teams as $t) {
			echo "<a href=\"?exam=" . $exam . "&team=" . $t['team_id'] .
				"\"><li><span class=\"li_left\">" . $t['teamname'] . "</span><span class=\"li_right\">---分</span></li></a>";
		}
	?>
	</ul>
</div>
