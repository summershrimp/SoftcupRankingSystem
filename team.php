<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?exam=<?php echo $exam; ?>'" />
	<h3><?php $a=get_topic_by_id($exam); echo $a['topicname']; ?></h3>
	<h3 style="margin-bottom:-5px"><?php $a=get_team_by_id($team); echo $a['teamname']; ?></h3>
	<form action="?action=post_score" method="post">
		<?php
			$items = get_topic_items($exam);
			$count = 0;
			foreach ($items as $i) {
				$count++;
				echo "<div class=\"form_row_container\">";
				echo "<div class=\"form_desc\"><b>" . $i['itemname'] . "</b><br />" . $i['comment'] . "</div>";
				echo "<span class=\"form_left\">得分</span>";
				echo "<select name=\"int" . $i['item_id'] . "\">";
				for ($j = 0; $j <= $i['maxscore']; $j++) echo "<option>" . $j . "</option>";
				echo "</select>";
				echo "<span style='width:4%;display:inline-block;text-align:center'><b>.</b></span>";
				echo "<select name=\"float" . $i['item_id'] . "\">";
				for ($j = 0; $j <= 9; $j++) echo "<option>" . $j . "</option>";
				echo "</select>";
				echo "</div>";
			}
		?>
		<div class="form_row_container">
			<input class="button" type="submit" value="提交" />
		</div>
	</form>
</div>
