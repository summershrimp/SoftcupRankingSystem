<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?exam=<?php echo $exam; ?>'" />
	<h3>题目</h3>
	<h3>队伍</h3>
	<form action="post_score.php" method="post">
		<?php
			$items = get_topic_items($exam);
			$count = 0;
			foreach ($items as $i) {
				$count++;
				echo "<div class=\"form_row_container\">";
				echo "<span class=\"form_left\">#" . $count . "</span>";
				echo "<input class=\"form_right\" type=\"number\" min=\"0\" max=\"" .
					$i['maxscore'] . "\" name=\"" . $i['item_id'] . "\" title=\"范围：0~" . $i['maxscore'] .
					"\" placeholder=\"范围：0~" . $i['maxscore'] . "\" autofocus required />";
				echo "<div class=\"form_desc\"><b>" . $i['itemname'] . "</b><br />" . $i['comment'] . "</div>";
				echo "</div>";
			}
		?>
		<div class="form_row_container">
			<input class="button" type="submit" value="提交" />
		</div>
	</form>
</div>
