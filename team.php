<?php
	if (!defined("IN_SCRS")) exit();
?>
<script>
	function check(id, cur, max) {
		var dom=document.getElementById("float-"+id);
		dom.innerHTML="";
		if (cur == max) {
			ts=document.createElement("option");
			ts.innerHTML=0;
			dom.appendChild(ts);
		}
		else {
			var ts;
			for (var i = 0; i < 10; i++) {
				ts=document.createElement("option");
				ts.innerHTML=i;
				dom.appendChild(ts);
			}
		}
	}
</script>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?exam=<?php echo $exam; ?>'" />
	<h3><?php $a=get_topic_by_id($exam); echo $a['topicname']; ?></h3>
	<h3 style="margin-bottom:-5px"><?php $a=get_team_by_id($team); echo $a['teamname']; ?></h3>
	<form action="?action=post_score&exam=<?php echo $exam; ?>&team=<?php echo $team; ?>" method="post">
		<?php
			$confirmed = $user->is_confirmed($exam, $team);
			$items = get_topic_items($exam);
			$items = array_sort($items, 'item_id');
			$scores = $user->get_team_scores($team);
			$scores = array_sort($scores, 'collect_id');
			$temp = array();
			$count = 0;
			foreach ($scores as $key => $value) {
				$temp[$count] = $value;
				$count++;
			}
			$scores = $temp;
			$none = ($user->get_team_total_scores($team) == 0);
			$count = 0;
			foreach ($items as $i) {
				$count++;
				$score = $none ? $i['maxscore'] : $scores[$count - 1]['score'];
				$score = explode(".", strval($score));
				if (!isset($score[1])) $score[1] = 0;
				echo "<div class=\"form_row_container\">";
				echo "<div class=\"form_desc\"><b>" . $i['itemname'] . "</b><br />" . $i['comment'] . "</div>";
				$hidden = ($i['maxscore'] == 0) ? " hidden" : "";
				echo "<div style='background:#DDD;padding:0;margin:0 auto' class=\"form_desc\">";
				echo "<span style='width:56%' class=\"form_left" . $hidden . "\">得分</span>";
				echo "<select " . ($confirmed ? "disabled" : "") . " class=\"" . $hidden . "\" name=\"int-" . $i['item_id'] . "\" onchange=\"check(" . $i['item_id'] . ",this.value," . $i['maxscore'] . ")\">";
				for ($j = 0; $j <= $i['maxscore']; $j++) {
					if ($j == $score[0]) echo "<option selected='selected'>" . $j . "</option>";
					else echo "<option>" . $j . "</option>";
				}
				echo "</select>";
				echo "<span class=\"form_left" . $hidden . "\"><b>.</b></span>";
				echo "<select id=\"float-" . $i['item_id'] . "\" " . ($confirmed ? "disabled" : "") . " class=\"" . $hidden . "\" name=\"float-" . $i['item_id'] . "\">";
				if ($score[0] == $i['maxscore']) {
					echo "<option>0</option>";
				}
				else {
					for ($j = 0; $j <= 9; $j++) {
						if ($j == $score[1]) echo "<option selected='selected'>" . $j . "</option>";
						else echo "<option>" . $j . "</option>";
					}
				}
				echo "</select>";
				echo "<span style='border:none;width:10%;margin:0' class=\"form_left" . $hidden . "\">分</span>";
				echo "</div>";
				echo "</div>";
			}
		?>
		<div class="form_desc form_row_container">
			<h4 style="margin:5px">评审意见及特殊说明</h4>
			<textarea<?php echo ($confirmed ? " disabled" : ""); ?> style="width:90%;height:8em" name="feedback" title="评审意见及特殊说明"><?php echo $user->get_feedback($team); ?></textarea>
		</div>
		<div class="form_row_container">
			<?php echo (
				$confirmed ?
				"<input disabled class=\"button\" type=\"submit\" value=\"已提交\" />" :
				"<input class=\"button\" type=\"submit\" value=\"保存\" />"
				);
			?>
		</div>
	</form>
</div>
