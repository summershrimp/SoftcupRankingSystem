<?php
define('IN_SCRS','true');
require_once './includes/init.inc.php';

$topic = get_all_topics();
?>
<html>
	<body>
	<?php 
	foreach($topic as $t)
		echo "<a href=\"team.php?topic=".$t['topic_id']."\">".$t['topicname'].$t['comment']."</a></br>";
	
	?>
	</body>
</html>
