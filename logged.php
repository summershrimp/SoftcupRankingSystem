<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script src="js/conf.js"></script>
<div id="test">
	<h3>请选择题目</h3>
	<ul>
	<?php
		$topic = get_all_topics();
		$privilege = $user->get_user_privilege();
		$statics = $user->get_statics();
		$unrated = false;
		foreach ($topic as $t) {
			if (isset($privilege[$t['topic_id']]) && $privilege[$t['topic_id']] == 1) {
				echo "<a href=\"?exam=" . $t['topic_id'] . "\"><li>" .
					"<span style=\"max-width:55%\" class=\"li_left\">" . $t['topicname'] . "</span>" .
					"<span class=\"li_right\">" . $statics[$t['topic_id']]['rated'] . " / " . $statics[$t['topic_id']]['total'] . "</span>" .
					"</li></a>";
				if ($statics[$t['topic_id']]['rated'] != $statics[$t['topic_id']]['total']) $unrated = true;
			}
		}
	?>
	</ul>
	<input class="button" type="button" value="提交所有题目" onclick="conf('?action=do_submit','<?php
		echo ($unrated ? "有未评分的队伍，确认提交？提交后不可更改。" : "提交后不可更改，确定？");
	?>')" />
</div>