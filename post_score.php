<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	$points = array();
	foreach ($_POST as $key => $value) {
		if ($key == "feedback") {
			$user->add_feedback($team, $value);
		}
		else {
			$t = explode("-", $key);
			if (isset($points[$t[1]])) {
				$points[$t[1]] += intval($value) * (($t[0] == "int") ? 1 : 0.1);
			}
			else {
				$points[$t[1]] = intval($value) * (($t[0] == "int") ? 1 : 0.1);
			}
		}
	}
	if ($user->add_collects($exam, $team, $points)) {
		relocate("?exam=".$exam);
	}
	else {
		echo "<div id='content'>";
		echo "<h4>评分过程中发生了错误。</h4>";
		echo "<input class='button' type='button' onclick='window.history.go(-1)' value='返回' />";
		echo "</div>";
	}
?>