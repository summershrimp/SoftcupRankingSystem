<?php
define('IN_SCRS','true');
require_once './includes/init.inc.php';

if(!isset($_GET['topic']))
	relocate("topic.php");
$teams = get_teams($_GET['topic']);

?>

<html>
	<body>
	<?php 
	foreach($teams as $t)
		echo "<a href=\"collection.php?topic=".$_GET['topic']."&team=".$t['team_id']."\">".$t['teamname'].$t['comment']."</a></br>"
	?>
	</body>
</html>
