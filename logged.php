<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<h3>请选择题目</h3>
	<ul>
	<?php
		$topic = get_all_topics();
		$privilege = $user->get_user_privilege();
		foreach($topic as $t) {
			if (isset($privilege[$t['topic_id']]) && $privilege[$t['topic_id']] == 1) {
				echo "<a href=\"?exam=" . $t['topic_id'] . "\"><li>" . $t['topicname'] . "</li></a>";
			}
		}
	?>
	</ul>
</div>