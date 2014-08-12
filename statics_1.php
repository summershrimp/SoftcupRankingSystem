<?php
	if (!defined("IN_SCRS")) exit();
?>
<?php if (isset($_GET['exam'])) {
	$exam = get_topic_by_id($_GET['exam']);
?>
	<div id="content">
		<input class="button back" type="button" value="返回" onclick="window.location='?action=statics&id=1'" />
		<h3>分赛题分数统计表</h3>
		<h3><?php echo $exam['topicname']; ?></h3>
		<h3>请选择评分老师</h3>
		<ul>
		<?php
			$users = $user->get_all_privilege();
			if (isset($users[$_GET['exam']])) {
				$users = $users[$_GET['exam']];
				foreach ($users as $key => $value) {
					if ($value == 1) {
						$getuser = $user->get_user_by_id($key);
						echo "<li onclick=\"window.open('?action=show_statics&id=1&exam=" . $_GET['exam']. "&user=" . $key . "','_blank')\">" . $getuser['realname'] . "</li>";
					}
				}
			}
		?>
		</ul>
	</div>
<?php } else { ?>
	<div id="content">
		<input class="button back" type="button" value="返回" onclick="window.location='?action=statics'" />
		<h3>分赛题分数统计表</h3>
		<h3>请选择赛题</h3>
		<ul>
		<?php
			$topic = get_all_topics();
			foreach($topic as $t) {
				echo "<li onclick=\"window.location.href='?action=statics&id=1&exam=" . $t['topic_id'] . "'\">" . $t['topicname'] . "</li>";
			}
		?>
		</ul>
	</div>
<?php } ?>