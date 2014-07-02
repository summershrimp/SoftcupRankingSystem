<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script>
	function check(id, cur, max) {
		var dom=document.getElementsByName("float-"+id)[0];
		if (cur == max) {
			dom.innerHTML="<option>0</option>";
		}
		else {
			dom.innerHTML="";
			for (var i = 0; i < 10; i++) {
				dom.innerHTML+="<option>"+i+"</option>";
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
				echo "<span class=\"form_left" . $hidden . "\">得分</span>";
				echo "<select style=\"width:20%\" class=\"" . $hidden . "\" name=\"int-" . $i['item_id'] . "\" onchange=\"check(" . $i['item_id'] . ",this.value," . $i['maxscore'] . ")\">";
				for ($j = 0; $j <= $i['maxscore']; $j++) {
					if ($j == $score[0]) echo "<option selected='selected'>" . $j . "</option>";
					else echo "<option>" . $j . "</option>";
				}
				echo "</select>";
				echo "<span class=\"form_left" . $hidden . "\" style='background:#FFF;width:4%;display:inline-block;text-align:center;margin-left:-1px'><b>.</b></span>";
				echo "<select style=\"width:20%\" class=\"" . $hidden . "\" name=\"float-" . $i['item_id'] . "\">";
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
				echo "<span class=\"form_left" . $hidden . "\" style=\"width:6.05%;margin-left:-1px\">分</span>";
				echo "</div>";
			}
		?>
		<div class="form_desc form_row_container">
			<h4 style="margin:5px">评审意见及特殊说明</h4>
			<textarea style="width:90%;height:8em" name="feedback" title="评审意见及特殊说明"><?php echo $user->get_feedback($team); ?></textarea>
		</div>
		<div class="form_row_container">
			<input class="button" type="submit" value="提交" />
		</div>
	</form>
</div>
