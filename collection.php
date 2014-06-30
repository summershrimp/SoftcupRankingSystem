<?php
define('IN_SCRS','true');
require_once './includes/init.inc.php';

if(isset($_GET['act'])&&$_GET['act']=='submit')
{
	$topic_id = $_GET['topic'];
	$team_id = $_GET['team'];
	if($user->add_collects($topic_id, $team_id, $_POST))
		echo "评分成功";
	else echo "评分失败";
	die();
}



if(!isset($_GET['topic'])||!isset($_GET['team']))
	relocte("index.php");
$items = get_topic_items($_GET['topic']);
?>

<html>
	<body>
	<?php 
	echo "<form action=\"collection.php?act=submit&topic=".$_GET['topic']."&team=".$_GET['topic']."\" method=\"post\">";
	foreach($items as $i)
	{
		echo $i['itemname'].$i['comment']."满分：".$i['maxscore']."----";
		echo "<input type=\"text\" name=\"".$i['item_id']."\" /><br/>";
	}
	echo "<input type=\"submit\"/>";
	echo "</form>";
	?>

	
	</body>
</html>
