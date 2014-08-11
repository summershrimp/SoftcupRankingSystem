<?php
	if (!defined("IN_SCRS")) exit();
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$team = get_team_by_id($_GET['id']);
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manteam'" />
	<h3>修改队伍：编号<?php echo $team['team_no']; ?></h3>
	<form action="?action=do_editteam&id=<?php echo $_GET['id']; ?>" method="post">
		<div class="form_row_container">
			<span class="form_left thin">* 名称</span><input class="form_right thin" type="text" name="title" title="名称" value="<?php echo $team['teamname'] ?>" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">描述</span><span class="form_right thin" style="width:15%;margin:0 0.5599px"><textarea name="desc" title="描述"><?php echo $team['comment'] ?></textarea></span>
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 选题</span><select class="thin" name="exam">
				<?php
					$topic = get_all_topics();
					foreach($topic as $t) {
						echo "'<option" . (($t['topic_id'] == $team['topic_id']) ? " selected=\"selected\"" : "") . " value=\"" . $t['topic_id'] . "\">" . $t['topicname'] . "</option>'+";
					}
				?>
			</select>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>