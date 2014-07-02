<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script>
	var id = 0;
	function del() {
		if (id == 1) {
			alert("至少需要一个用户！");
			return false;
		}
		var a = document.getElementById("user"+id);
		id--;
		a.style.height=0;
		setTimeout(function(){
			a.parentNode.removeChild(a);
		},500)
	}
	function cre() {
		id++;
		var s =
			'<div id="user'+id+'" class="insert">'+
				'<h4>用户 #'+id+'</h4>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">* 用户名</span>\n'+
					'<input class="form_right thin" type="text" name="name[]" title="用户名" required />'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">* 密码</span>\n'+
					'<input class="form_right thin" type="password" name="password[]" title="密码" required />'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">* 用户类型</span>\n'+
					'<select class="thin" name="type[]">'+
					<?php
						$roles = $user->get_all_roles();
						foreach ($roles as $e) {
							echo "'<option value=\"" . $e['role_id'] . "\">" . $e['rolename'] . "</option>'+";
						}
					?>
					'</select>'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">* 性别</span>\n'+
					'<select class="thin" name="sex[]">'+
						'<option value="0">男</option>'+
						'<option value="1">女</option>'+
					'</select>'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">* 真实姓名</span>\n'+
					'<input class="form_right thin" type="text" name="realname[]" title="真实姓名" required />'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">手机</span>\n'+
					'<input class="form_right thin" type="mobile" name="phone[]" title="手机" />'+
				'</div>'+
				'<div class="form_row_container">'+
					'<span class="form_left thin">备注</span>\n'+
					'<input class="form_right thin" type="text" name="comment[]" title="备注" />'+
				'</div>'+
			'</div>';
		document.getElementById("user_list").innerHTML+=s;
		document.getElementById("user"+id).style.height=340+"px";
	}
</script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manuser'" />
	<h3>添加用户</h3>
	<form action="?action=do_adduser" method="post">
		<p><a href="#" onclick="cre()">[追加一个新的用户]</a></p>
		<p><a href="#" onclick="del()">[删除最后一个用户]</a></p>
		<div id="user_list">
			<script>cre();</script>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>
