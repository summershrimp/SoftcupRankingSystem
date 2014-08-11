<?php
	if (!defined("IN_SCRS")) exit();
?>
<script src="js/conf.js"></script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<input class="button" type="button" value="添加新用户" onclick="window.location='?action=adduser'" />
	<h3>用户列表</h3>
	<form action="?action=deluser" method="post">
		<table>
			<tr><!--<th>#</th>--><th style="width:55px;min-width:55px">操作</th><th>用户名</th><th>用户类型</th><th>管理员</th><th>性别</th><th>真实姓名</th><th>手机</th><th>备注</th></tr>
			<?php
				$user_list = $user->get_all_users();
				foreach ($user_list as $e) {
					$role = get_role_by_id($e['role_id']);
					echo "<tr>";
					//echo "<td><input type='checkbox' name='chk[]' value='" . $e['topic_id'] . "' /></td>";
					echo "<td class='click warning' onclick=\"conf('?action=do_deluser&id=" . $e['user_id'] . "','确定要删除这条记录吗？')\">删除</td>";
					echo "<td class='click' onclick=\"window.location.href='?action=edituser&id=" . $e['user_id'] . "'\">" . $e['username'] . "</td>";
					echo "<td>" . $role['rolename'] . "</td>";
					// 可以删除管理员 还是 只能删除普通用户？
					echo "<td>" . (($e['isadmin'] == 1) ? "是" : "") . "</td>";
					echo "<td>" . (($e['sex'] == 0) ? "男" : "女") . "</td>";
					echo "<td>" . $e['realname'] . "</td>";
					echo "<td>" . $e['phone'] . "</td>";
					echo "<td>" . $e['comment'] . "</td>";
					echo "</tr>";
				}
			?>
		</table>
		<!--<input class="button delete" type="submit" value="批量删除" />-->
	</form>
</div>