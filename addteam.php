<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<script>
	var id = 0;
	function del() {
		if (id == 1) {
			alert("至少需要一个队伍！");
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
			'<h4>队伍 #'+id+'</h4>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 队伍编号</span>'+
				'<input class="form_right thin" type="text" name="no[]" title="队伍编号" required />'+
			'</div>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 队伍名称</span>'+
				'<input class="form_right thin" type="text" name="name[]" title="队伍名称" required />'+
			'</div>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">队伍描述</span>'+
				'<input class="form_right thin" type="text" name="desc[]" title="队伍描述" />'+
			'</div>'+
			'<div class="form_row_container">'+
				'<span class="form_left thin">* 赛题选择</span>'+
				'<select class="thin" name="exam[]">'+
				<?php
					$topic = get_all_topics();
					foreach($topic as $t) {
						echo "'<option value=\"" . $t['topic_id'] . "\">" . $t['topicname'] . "</option>'+";
					}
				?>
				'</select>'+
			'</div>';
		document.getElementById("item_list").appendChild(dom);
		document.getElementById("item"+id).style.height=220+"px";
	}
</script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?action=manteam'" />
	<h3>添加队伍</h3>
	<form action="?action=do_addteam" method="post">
		<p><a href="#" onclick="cre()">[追加一个新的队伍]</a></p>
		<p><a href="#" onclick="del()">[删除最后一个队伍]</a></p>
		<div id="item_list">
			<script>cre();</script>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>
