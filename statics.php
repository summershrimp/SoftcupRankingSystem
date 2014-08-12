<?php
	if (!defined("IN_SCRS")) exit();
?>
<div id="content">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>请选择表格类型</h3>
	<ul>
		<li onclick="window.location.href='?action=statics&id=1'">评分确认表</li>
		<li onclick="window.location.href='?action=statics&id=2'">分赛题分数统计表</li>
		<li onclick="window.open('?action=show_statics&id=3','_blank')">分数汇总</li>
	</ul>
</div>