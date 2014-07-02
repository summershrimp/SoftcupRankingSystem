<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<h3>内容</h3>
	<ul>
		<li onclick="window.location='?action=manexam'">赛题管理</li>
		<li onclick="window.location='?action=manteam'">队伍管理</li>
		<li onclick="window.location='?action=manuser'">用户管理</li>
		<li onclick="window.location='?action=statics'">数据统计</li>
		<li onclick="window.open('?action=privilege','_blank','toolbar=no,menubar=no,location=no,scrollbars=yes,status=no')">权限管理</li>
	</ul>
</div>