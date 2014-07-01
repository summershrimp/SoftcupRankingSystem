<header>
	<h1>
	<?php
		if ($user->is_admin()) echo "管理后台";
		else echo "软件杯评分系统";
	?>
	</h1>
	<a href="?action=logout"><span id="logout">注销</span></a>
</header>
