<?php
if (! defined ( 'IN_SCRS' ))
{
	die ( 'Hacking attempt' );
}

function get_all_topics()
{
	$sql = "Select * From ".$GLOBALS['sc']->table('topics')." Order By `disp`";
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

function get_team_by_id($team_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('teams')." Where `team_id` = '".$team_id."' LIMIT 1";
	return $arr = $GLOBALS['db']->getRow($sql);
}

function get_role_by_id($role_id)
{

	$sql = "Select * From ".$GLOBALS['sc']->table('roles')." Where `role_id` = '$role_id'";
	$arr = $GLOBALS['db']->getRow($sql);
	return $arr;
	
}

function get_topic_items($topic_id)
{
	$sql = "Select * From ".$GLOBALS['sc']->table('items')." Where `topic_id` = '".$topic_id."' Order By `disp`";
	return $arr = $GLOBALS['db']->getAll($sql);
}

function get_collects($topic_id)
{
	$sql =  "Select ".$GLOBALS['sc']->table('users').".`user_id`, ".
			$GLOBALS['sc']->table('users').".`role_id`, ".
			$GLOBALS['sc']->table('users').".`realname` ".
		    "From ".$GLOBALS['sc']->table('users')." ".
			"Right Join ".$GLOBALS['sc']->table('user_privileges')." ".
			"On ".$GLOBALS['sc']->table('user_privileges').".`user_id` = ".$GLOBALS['sc']->table('users').".`user_id`".
			"Where ".$GLOBALS['sc']->table('user_privileges').".`topic_id` = '$topic_id' Order By `role_id`";
	$result = $GLOBALS['db']->query($sql);
	$user_array = Array();
	while($arr = $GLOBALS['db']->fetchRow($result))
	{
		$user_array[$arr['user_id']]['realname'] = $arr['realname'];
		$user_array[$arr['user_id']]['role_id'] = $arr['role_id'];
	}
	
	$sql = "Select `team_id`, `teamname` From ".$GLOBALS['sc']->table('teams')." ".
			"Where `topic_id` = '$topic_id' ";
	$result = $GLOBALS['db']->query($sql);
	$team_array = Array();
	while($arr = $GLOBALS['db']->fetchRow($result))
		$team_array[$arr['team_id']] = $arr['teamname'];

	$sql = "Select `role_id`, `balance` From ".$GLOBALS['sc']->table('roles');
	$result = $GLOBALS['db']->query($sql);
	$role_array = Array();
	while($arr = $GLOBALS['db']->fetchRow($result))
		$role_array[$arr['role_id']] = $arr['balance'];
	
	$ret = Array();
	
	$ret['users'] = $user_array;
	foreach ($team_array as $tkey => $tvalue)
	{
		$ret['contents'][$tkey]['teamname'] = $tvalue;
		$sumall=0.0;
		$sumbal=0.0;
		foreach($user_array as $ukey => $uvalue)
		{
			$sql = "Select Sum(`score`) as `score` From ". $GLOBALS['sc']->table('collects') ." Where `user_id` = '$ukey' And `team_id` = '$tkey' ";
			$arr = $GLOBALS['db']->getRow($sql);
			if(isset($arr['score']))
			{
				$sum = floatval($arr['score']);
				$sumall += $sum * floatval($role_array[$uvalue['role_id']]);
				$sumbal += floatval($role_array[$uvalue['role_id']]);
				$ret['contents'][$tkey]['scores'][$ukey] = $sum;
			}
			else 
				$ret['contents'][$tkey]['scores'][$ukey] = -1;
		}
		if($sumall == 0.0)
			$ret['contents'][$tkey]['avescore'] = -1;
		else
			$ret['contents'][$tkey]['avescore'] = $sumall / floatval($sumbal);
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