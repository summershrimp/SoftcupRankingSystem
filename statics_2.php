<?php
	if (!defined("IN_SCRS")) exit();
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=statics'" />
	<h3>分赛题分数统计表</h3>
	<h3>请选择赛题</h3>
	<ul>
	<?php
		$topic = get_all_topics();
		foreach($topic as $t) {
			echo "<li onclick=\"window.open('?action=show_statics&id=2&exam=" . $t['topic_id'] . "','_blank')\">" . $t['topicname'] . "</li>";
		}
	?>
	</ul>
</div>