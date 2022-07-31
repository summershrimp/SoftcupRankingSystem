<?php
	if (!defined("IN_SCRS")) exit();
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3><?php $a=get_topic_by_id($exam); echo $a['topicname']; ?></h3>
	<h3>请选择队伍</h3>
	<ul>
	<?php
		$teams = get_teams($exam);
		foreach($teams as $t) {
			echo "<a href=\"?exam=" . $exam . "&team=" . $t['team_id'] .
				"\"><li id=\"" . $t['team_id'] . "\"><span style=\"max-width:55%\" class=\"li_left\">" . $t['teamname'] . "</span><span class=\"li_right\">";
			$score = $user->get_team_total_scores($t['team_id']);
			if ($score == 0) echo "<span style=\"color:red\">未评分</span>";
			else echo "<span style=\"color:green\">" . $score . "分</span>";
			echo "</span></li></a>";
		}
	?>
	</ul>
</div>
