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

function get_topic_by_id($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('topics')." Where `topic_id` = '".$topic_id."' LIMIT 1";
	return $arr = $GLOBALS['db']->getRow($sql);
}

function get_user_realname_by_id($user_id)
{
	$sql = "Select `realname` From ".$GLOBALS['sc']->table('users')." Where `user_id` = '".$user_id."' LIMIT 1";
	return $arr = $GLOBALS['db']->getOne($sql);
}

function get_teams($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('teams')." Where `topic_id` = '".$topic_id."'";
	return $arr = $GLOBALS['db']->getAll($sql);
}
function get_all_teams()
{
	$sql = "Select * From ".$GLOBALS['sc']->table('teams');
	return $arr = $GLOBALS['db']->getAll($sql);
}
function get_all_users()
{
	$sql = "Select * From ".$GLOBALS['sc']->table('users');
	return $arr = $GLOBALS['db']->getAll($sql);
}
function get_team_by_id($team_id)
{
	$sql = $sql = "Select * From ".$GLOBALS['sc']->table('teams')." Where `team_id` = '".$team_id."' LIMIT 1";
	return $arr = $GLOBALS['db']->getRow($sql);
}
function get_user_by_id($user_id)
{
	$sql = $sql = "Select * From ".$GLOBALS['sc']->table('users')." Where `user_id` = '".$user_id."' LIMIT 1";
	return $arr = $GLOBALS['db']->getRow($sql);
}
function get_topic_items($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('items')." Where `topic_id` = '".$topic_id."'";
	return $arr = $GLOBALS['db']->getAll($sql);
}

function get_collects($topic_id)
{
	$ret = Array();
	//$sql = "Select `user_id`, `team_id`, Sum(`score`) as `sum` From ".$GLOBALS['sc']->table('collects')." Where `topic_id` = '".$topic_id."' Group By `team_id`";
	$sql = 
	"Select ".$GLOBALS['sc']->table('users').".`role_id`,".$GLOBALS['sc']->table('collects').".`user_id`, `team_id`, Sum(`score`) as `sum` ".
	"From ".$GLOBALS['sc']->table('collects')." ".
	"Left Join ".$GLOBALS['sc']->table('users')." ".
	"On ".$GLOBALS['sc']->table('users').".`user_id` = ".$GLOBALS['sc']->table('collects').".`user_id` ".
	"Where `topic_id` = '".$topic_id."' Group By `user_id`, `team_id`";
	
	$result = $GLOBALS['db']->query($sql);
	$temp = Array();
	while($arr = $GLOBALS['db']->fetchRow($result))
	{
		$temp[$arr['team_id']][$arr['user_id']]['sum']=$arr['sum'];
		$temp[$arr['team_id']][$arr['user_id']]['role_id']=$arr['role_id'];
	}
	$sql = "Select `role_id`,`balance` From ".$GLOBALS['sc']->table('roles');
	$result = $GLOBALS['db']->query($sql);
	$roles = Array();
	while($arr = $GLOBALS['db']->fetchRow($result))
	{
		$roles[$arr['role_id']] = intval($arr['balance']);
	}
	$ret = Array();
	foreach($temp as $keyt => $team)
	{
		$all_balance = 0;
		$all_sum = 0;
		foreach($team as $keyu => $t)
		{
			$all_sum += $roles[$t["role_id"]]*$t['sum'];
			$all_balance += $roles[$t["role_id"]];
			$ret[$keyt]['scores'][$keyu]=$t['sum'];
		}
		$team_info = get_team_by_id($keyt);
		$ret[$keyt]['ave']=floatval($all_sum)/floatval($all_balance);
		$ret[$keyt]['teamname']=$team_info['teamname'];
	}
	return $ret;
}

function get_details($team_id,$user_id)
{	
	
	$team_info = get_team_by_id($team_id);
	$topic_info = get_topic_by_id($team_info['topic_id']);
	$ret = Array();
	$ret ["topicname"] = $topic_info["topicname"];
	$ret ["teamname"] = $team_info["teamname"];
	
	$sql = 
	"Select * ".
	"From ".$GLOBALS['sc']->table('items')." ".
	"Where `topic_id` = '".$team_info['topic_id']."'";
	$result = $GLOBALS['db']->query($sql);
	$item_info = Array();
	while($arr=$GLOBALS['db']->fetchRow($result))
	{
		$item_info[$arr['item_id']]['itemname']=$arr['itemname'];
		$item_info[$arr['item_id']]['maxscore']=$arr['maxscore'];
		$item_info[$arr['item_id']]['comment']=$arr['comment'];
	}
	$sql = 
	"Select `item_id`,`score` ".
	"From ".$GLOBALS['sc']->table('collects')." ".
	"Where `team_id` = '$team_id' AND `user_id` = '$user_id'";
	$result = $GLOBALS['db']->query($sql);
	
	while($arr=$GLOBALS['db']->fetchRow($result))
	{
		$ret["items"][$arr["item_id"]] = $item_info[$arr['item_id']];
		$ret["items"][$arr["item_id"]]['score'] = $arr['score'];
	}
	return $ret;
}
?>