<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="content">
	<h3>请选择赛题</h3>
	<ul>
	<?php
		$topic = get_all_topics();
		foreach($topic as $t) {
			echo "<a href=\"?action=show_statics&exam=" . $t['topic_id'] . "\"><li>" . $t['topicname'] . "</li></a>";
		}
	?>
	</ul>
</div>