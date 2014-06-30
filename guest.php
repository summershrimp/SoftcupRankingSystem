<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div>
	<h1>请登录</h1>
	<form action="?action=login" method="post">
		<div class="form_row_container">
			<span class="form_left">用户名</span>
			<input class="form_right" type="text" name="username" title="请输入用户名。" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left">密码</span>
			<input class="form_right" type="password" name="password" title="请输入密码。" required />
		</div>
		<div class="form_row_container">
			<input class="button" type="submit" value="登录" />
			<input class="button" type="reset" value="重写" />
		</div>
	</form>
</div>
