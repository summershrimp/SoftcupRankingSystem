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
	function safe_html($str) {
		return htmlentities($str, ENT_QUOTES, "UTF-8");
	}
	function encode($value) {
		if (empty($value)) {
			return $value;
		}
		else {
			return is_array($value) ? array_map('encode', $value) : safe_html($value);
		}
	}
	$_GET = encode($_GET);
	$_POST = encode($_POST);
	$_COOKIE = encode($_COOKIE);
	$_REQUEST = encode($_REQUEST);
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
		for(var i=0;i<list.length;i++){
			var e=list[i];
			var a=document.getElementsByTagName(e);
			for (var i=0;i<a.length;i++) a[i].addEventListener("touchstart",function(){},false);
		};
	</script>
</body>
</html>