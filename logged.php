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
		foreach($topic as $t) {
			echo "<a href=\"?exam=" . $t['topic_id'] . "\"><li>" . $t['topicname'] . "</li></a>";
		}
	?>
	</ul>
</div>
