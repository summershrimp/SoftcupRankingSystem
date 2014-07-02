<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$tuser = $user->get_user_by_id($_GET['id']);
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manuser'" />
	<h3>编辑用户信息</h3>
	<form action="?action=do_edituser&id=<?php echo $_GET['id']; ?>" method="post">
		<div class="form_row_container">
			<span class="form_left thin">* 用户名</span><input class="form_right thin" type="text" name="username" title="用户名" value="<?php echo $tuser['username'] ?>" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 用户类型</span><select class="thin" name="type">
			<?php
				$roles = $user->get_all_roles();
				foreach ($roles as $e) {
					echo "<option value=\"" . $e['role_id'] . "\"";
					if ($e['role_id'] == $tuser['role_id']) echo " selected=\"selected\"";
					echo ">" . $e['rolename'] . "</option>";
				}
			?>
			</select>
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 性别</span><select class="thin" name="sex">
				<option<?php if ($tuser['sex'] == 0) echo " selected=\"selected\""; ?>>男</option>
				<option<?php if ($tuser['sex'] == 1) echo " selected=\"selected\""; ?>>女</option>
			</select>
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 真实姓名</span><input class="form_right thin" type="text" name="realname" title="真实姓名" value="<?php echo $tuser['realname'] ?>" required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">手机</span><input class="form_right thin" type="mobile" name="phone" title="手机" value="<?php echo $tuser['phone'] ?>" />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">备注</span><input class="form_right thin" type="text" name="comment" title="备注" value="<?php echo $tuser['comment'] ?>" />
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>