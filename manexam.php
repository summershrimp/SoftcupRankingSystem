<?php
	if (!defined("IN_SCRS")) exit();
?>
<script src="js/conf.js"></script>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<input class="button" type="button" value="添加新题目" onclick="window.location='?action=addexam'" />
	<h3>赛题列表</h3>
	<form action="?action=delexam" method="post">
		<table>
			<tr><!--<th>#</th>--><th style="width:55px;min-width:55px">操作</th><th>题目</th><th>描述</th></tr>
			<?php
				$exam_list = get_all_topics();
				foreach ($exam_list as $e) {
					echo "<tr>";
					//echo "<td><input type='checkbox' name='chk[]' value='" . $e['topic_id'] . "' /></td>";
					echo "<td class='click warning' onclick=\"conf('?action=do_delexam&id=" . $e['topic_id'] . "','确定要删除这条记录吗？')\">删除</td>";
					echo "<td class='click' onclick=\"window.location.href='?action=editexam&id=" . $e['topic_id'] . "'\">" . $e['topicname'] . "</td>";
					echo "<td><span class='ell'>" . $e['comment'] . "</span></td>";
					echo "</tr>";
				}
			?>
		</table>
		<!--<input class="button delete" type="submit" value="批量删除" />-->
	</form>
</div>