<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script>
	var id = 1;
	function del() {
		if (id == 1) {
			alert("至少需要一个测试点！");
			return false;
		}
		var a = document.getElementById("judge"+id);
		a.parentNode.removeChild(a);
		id--;
	}
	function cre() {
		id++;
		var s = '<div id="judge'+id+'">'+
					'<h4>评测点 #'+id+'</h4>'+
					'<div class="form_row_container">'+
						'<span class="form_left thin">评测点名称</span>'+
						'<input class="form_right thin" type="text" name="point_title" required />'+
					'</div>'+
					'<div class="form_row_container">'+
						'<span class="form_left thin">评测点描述</span>'+
						'<input class="form_right thin" type="text" name="point_desc" required />'+
					'</div>'+
				'</div>';
		document.getElementById("judge_list").innerHTML+=s;
	}
</script>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>请填写赛题信息</h3>
	<form action="?do_addexam" method="post">
		<div class="form_row_container">
			<span class="form_left thin">赛题名称</span>
			<input class="form_right thin" type="text" name="title" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">赛题描述</span>
			<span class="form_right thin" style="width:15%;margin:0 0.5599px"><textarea name="desc" required></textarea></span>
		</div>
		<p><a href="#" onclick="cre()">[追加一个新的评测点]</a></p>
		<p><a href="#" onclick="del()">[删除最后一个评测点]</a></p>
		<div id="judge_list">
			<div id="judge1">
				<h4>评测点 #1</h4>
				<div class="form_row_container">
					<span class="form_left thin">评测点名称</span>
					<input class="form_right thin" type="text" name="point_title" required />
				</div>
				<div class="form_row_container">
					<span class="form_left thin">评测点描述</span>
					<input class="form_right thin" type="text" name="point_desc" required />
				</div>
			</div>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>
