<?php
if (! defined ( 'IN_SCRS' ))
{
	die ( 'Hacking attempt' );
}

function get_all_topics()
{
	$sql = "Select * From ".$GLOBALS['sc']->table('topics');
	return $arr = $GLOBALS['db']->getAll($sql);
}

function get_teams($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('teams')." Where `topic_id` = '".$topic_id."'";
	return $arr = $GLOBALS['db']->getAll($sql);
}

function get_topic_items($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('items')." Where `topic_id` = '".$topic_id."'";
	return $arr = $GLOBALS['db']->getAll($sql);
}

function get_collects($topic_id)
{
	$ret = Array();
	$sql = "Select `user_id`, `item_id`, `team_id`, `score` From ".$GLOBALS['sc']->table('items')." Where `topic_id` = '".$topic_id."'";
	$result = $GLOBALS['db']->query($sql);
	while($arr = $GLOBALS['db']->fetchRow($result))
		$ret[$arr['team_id']][$arr['user_id']][$arr['item_id']] = $arr['score'];
	return $ret;
}

?>