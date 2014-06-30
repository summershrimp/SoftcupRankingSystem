<?php
	define('IN_SCRS','true');
	require_once './includes/init.inc.php';
/*elseif($user->is_admin())
	relocate("admin/index.php");*/
	$exam = $team = 0;
	if (isset($_GET['exam'])) {
		$exam = $_GET['exam'];
	}
	if (isset($_GET['team'])) {
		$team = $_GET['team'];
	}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<?php require_once "header.php"; ?>
	<title>软件杯评分系统</title>
</head>
<body>
	<div id="container">
		<?php require_once "container.php"; ?>
	</div>
</body>
</html>
