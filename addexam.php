<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script>
	var id = 0;
	function del() {
		if (id == 1) {
			alert("至少需要一个测试点！");
			return false;
		}
		var a = document.getElementById("item"+id);
		id--;
		a.style.height=0;
		setTimeout(function(){
			a.parentNode.removeChild(a);
		},500)
	}
	function cre() {
		id++;
		var dom=document.createElement("div");
		dom.id="item"+id;
		dom.className="insert";
		dom.innerHTML=
			'<h4>评测点 #'+id+'</h4>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 评测点名称</span>'+
				'<input class="form_right thin" type="text" name="point_title[]" title="评测点名称" required />'+
			'</div>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 评测点描述</span>'+
				'<input class="form_right thin" type="text" name="point_desc[]" title="评测点描述" />'+
			'</div>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 分值</span>'+
				'<input class="form_right thin" type="number" name="point_score[]" title="分值" min="0" required />'+
			'</div>';
		document.getElementById("item_list").appendChild(dom);
		document.getElementById("item"+id).style.height=180+"px";
	}
</script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manexam'" />
	<h3>请填写赛题信息</h3>
	<form action="?action=do_addexam" method="post">
		<div class="form_row_container">
			<span class="form_left thin">* 赛题名称</span><input class="form_right thin" type="text" name="title" title="赛题名称" autofocus required />
		</div>
		<div class="form_row_container">
			<span class="form_left thin">* 赛题描述</span><span class="form_right thin" style="width:15%;margin:0 0.5599px"><textarea name="desc" title="赛题描述" required></textarea></span>
		</div>
		<p><a href="#" onclick="cre()">[追加一个新的评测点]</a></p>
		<p><a href="#" onclick="del()">[删除最后一个评测点]</a></p>
		<div id="item_list">
			<script>cre();</script>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>
