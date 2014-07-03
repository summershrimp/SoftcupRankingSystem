<?php
	define('IN_SCRS','true');
	require_once './includes/init.inc.php';
	/**/
	function array_sort($arr,$keys,$type='asc') { 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v) {
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc') {
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v) {
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	}
	/**/
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
	<script>
		var list=["a", "input", "li"];
		list.forEach(function (e) {
			var a=document.getElementsByTagName(e);
			for (var i=0;i<a.length;i++) a[i].addEventListener("touchstart",function(){},false);
		});
	</script>
</body>
</html>