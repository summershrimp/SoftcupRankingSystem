<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?'" />
	<h3>题目</h3>
	<h3>请选择队伍</h3>
	<ul>
		<a href="?exam=<?php echo $exam; ?>&team=1"><li><span class="li_left">队伍</span><span class="li_right">---分</span></li></a>
		<a href="?exam=<?php echo $exam; ?>&team=1"><li><span class="li_left">队伍</span><span class="li_right">---分</span></li></a>
		<a href="?exam=<?php echo $exam; ?>&team=1"><li><span class="li_left">队伍</span><span class="li_right">---分</span></li></a>
		<a href="?exam=<?php echo $exam; ?>&team=1"><li><span class="li_left">队伍</span><span class="li_right">---分</span></li></a>
	</ul>
</div>
