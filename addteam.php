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
		var a = document.getElementById("team"+id);
		a.parentNode.removeChild(a);
		id--;
	}
	function cre() {
		id++;
		var s = '<div id="team'+id+'">'+
					'<h4>队伍 #'+id+'</h4>'+
					'<div class="form_row_container">'+
						'<span class="form_left thin">队伍名称</span>\n'+
						'<input class="form_right thin" type="text" name="name[]" title="队伍名称" required />'+
					'</div>'+
					'<div class="form_row_container">'+
						'<span class="form_left thin">赛题选择</span>\n'+
						'<select class="thin" name="team[]">'+
						<?php
							$topic = get_all_topics();
							foreach($topic as $t) {
								echo "'<option value=\"" . $t['topic_id'] . "\">" . $t['topicname'] . "</option>'+";
							}
						?>
						'</select>'+
					'</div>'+
				'</div>';
		document.getElementById("team_list").innerHTML+=s;
	}
</script>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>添加队伍</h3>
	<form action="?do_addexam" method="post">
		<p><a href="#" onclick="cre()">[追加一个新的队伍]</a></p>
		<p><a href="#" onclick="del()">[删除最后一个队伍]</a></p>
		<div id="team_list">
			<script>cre();</script>
		</div>
		<input class="button" type="submit" value="提交" />
	</form>
</div>
