<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>请选择赛题</h3>
	<ul>
	<?php
		$topic = get_all_topics();
		foreach($topic as $t) {
			echo "<li onclick=\"window.open('?action=show_statics&exam=" . $t['topic_id'] . "','_blank')\">" . $t['topicname'] . "</li>";
		}
	?>
	</ul>
</div>