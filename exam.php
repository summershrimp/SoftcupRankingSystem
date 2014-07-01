<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3><?php echo get_topic_by_id($exam)['topicname'] ?></h3>
	<h3>请选择队伍</h3>
	<ul>
	<?php
		$teams = get_teams($exam);
		foreach($teams as $t) {
			echo "<a href=\"?exam=" . $exam . "&team=" . $t['team_id'] .
				"\"><li><span class=\"li_left\">" . $t['teamname'] . "</span><span class=\"li_right\">";
			$score = $user->get_team_scores($t['team_id']);
			if (sizeof($score) != 0) $score = $score[0];
			else $score = NULL;
			if ($score == NULL || $score['score'] == 0) echo "<span style=\"color:red\">未评分</span>";
			else echo "<span style=\"color:green\">" . $score['score'] . "分</span>";
			echo "</span></li></a>";
		}
	?>
	</ul>
</div>