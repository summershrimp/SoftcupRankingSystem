<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
	if (!isset($_GET['id'])) {
		relocate("javascript:window.history.go(-1)");
		die();
	}
	$user = get_user_by_id($_GET['id']);
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manuser'" />
	<h3>编辑用户信息</h3>
	<form action="?action=do_edituser&id=<?php echo $_GET['id']; ?>" method="post">
		<div class="form_row_container">
			<span class="form_left thin">* 用户名</span><input class="form_right thin" type="text" name="title" title="用户名" value="<?php echo $user['username'] ?>" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 用户类型</span><select class="thin" name="type">
				<option<?php if ($user['user_type'] == 0) echo " selected=\"selected\""; ?>>指导教师</option>
				<option<?php if ($user['user_type'] == 1) echo " selected=\"selected\""; ?>>企业代表</option>
				<option<?php if ($user['user_type'] == 2) echo " selected=\"selected\""; ?>>大学教师</option>
			</select>
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 性别</span><select class="thin" name="sex">
				<option<?php if ($user['sex'] == 0) echo " selected=\"selected\""; ?>>男</option>
				<option<?php if ($user['sex'] == 1) echo " selected=\"selected\""; ?>>女</option>
			</select>
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 真实姓名</span><input class="form_right thin" type="text" name="realname" title="真实姓名" value="<?php echo $user['realname'] ?>" required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">手机</span><input class="form_right thin" type="mobile" name="phone" title="手机" value="<?php echo $user['phone'] ?>" />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">备注</span><input class="form_right thin" type="text" name="comment" title="备注" value="<?php echo $user['comment'] ?>" />
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>