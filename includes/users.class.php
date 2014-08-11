<?php
if (! defined ( 'IN_SCRS' ))
{
    die ( 'Hacking attempt' );
}

class user
{
	
	private $user_info = NULL;
	
	public function user()
	{
		if(isset($_SESSION))
		{
			if(isset($_SESSION['username'])&&$_SESSION['password'])
			{
				if(!$this->login($_SESSION['username'],$_SESSION['password']))
				{
					$this->logout();
				}
			}
			else $this->logout();
		}
	}
	
	public function login($username, $password)
	{
		if($user_id = $this->check_login($username, $password))
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('users')." Where `user_id` = '".$user_id."' LIMIT 1";
			$this->user_info = $GLOBALS['db']->getRow($sql);
			unset($this->user_info['salt']);
			unset($this->user_info['password']);
			foreach($this->user_info as $key=>$value)
				$_SESSION[$key]=$value;
			$_SESSION['password']=$password;
			return $user_id;
		}
		else
		{
			$this->logout();
			return false;
		}
		return false;
	}
		
	public function get_id($username)
	{
		$sql = "Select `user_id` From ".$GLOBALS['sc']->table('users')." Where `username` = '".$username."' LIMIT 1";
		return $arr = $GLOBALS['db']->getOne($sql);
	}
	
	public function get_name($user_id)
	{
		$sql = "Select `username` From ".$GLOBALS['sc']->table('users')." Where `user_id` = '".$user_id."' LIMIT 1";
		return $arr = $GLOBALS['db']->getOne($sql);
	}
	
	public function is_admin()
	{
		if(!$this->is_login())
			return false;
		if($this->user_info != NULL)
			if($this->user_info['isadmin']==1)
				return true;
		return false;
	}
	
	public function is_login()
	{
		if(isset($_SESSION['user_id']))
			return true;
		return false;
	}
	
	public function confirm_team($team_id)
	{
		$sql = "Update ".$GLOBALS['sc']->table('confirms')." SET `is_confirmed` = '1' Where `user_id` = '".$this->user_info['user_id']."' AND `team_id` = '$team_id' LIMIT 1";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->affected_rows();
	}
	
	public function confirm_topic($topic_id)
	{
		
		$sql = "Update ".$GLOBALS['sc']->table('confirms')." SET `is_confirmed` = '1' Where `user_id` = '".$this->user_info['user_id']."' AND `topic_id` = '$topic_id' ";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->affected_rows();
		
	}
	
	public function confirm_all()
	{
	
		$sql = "Update ".$GLOBALS['sc']->table('confirms')." SET `is_confirmed` = '1' Where `user_id` = '".$this->user_info['user_id']."' ";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->affected_rows();
	
	}
	
	public function is_confirmed($topic_id, $team_id)
	{
		$sql = "Select `is_confirmed` From ".$GLOBALS['sc']->table('confirms')." Where `user_id` = '".$this->user_info['user_id']."' AND `team_id` = '$team_id' AND `topic_id` = '$topic_id' LIMIT 1";
		$ans = $GLOBALS['db']->getOne($sql);
		return $ans;
	}
	
	public function add_collects($topic_id,$team_id,$collects)
	{
		if(!$this->is_login()||$this->is_confirmed($topic_id,$team_id))
			return false;
		$GLOBALS['db']->query("Start Transcation");
		$sql = "DELETE From ".$GLOBALS['sc']->table('collects')." Where `user_id` = '".$this->user_info['user_id']."' AND `topic_id` = '".$topic_id."' AND `team_id` = '$team_id'";
		$GLOBALS['db']->query($sql);
		$count = 0;
		foreach($collects as $key => $value)
		{
			$sql = "Insert Into ".$GLOBALS['sc']->table('collects').
			" (`user_id`, `topic_id`, `item_id`,`team_id`, `score` )VALUES('".$this->user_info['user_id']."', '".$topic_id."', '".$key."', '".$team_id."','".$value."')";
			$result = $GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows() == 1)
				$count++;
		}
		$sql = "Select COUNT(*) From ".$GLOBALS['sc']->table('items')." Where `topic_id` = '".$topic_id."'";
		$allcount = $GLOBALS['db']->getOne($sql);
		if($allcount!=$count)
		{
			$GLOBALS['db']->query("Rollback");
			$GLOBALS['db']->query("Commit");
			return false;
		}
		$GLOBALS['db']->query("Commit");
		$sql = "Update ".$GLOBALS['sc']->table('confirms'). " SET `is_rated` = 1 Where `user_id` = '".$this->user_info['user_id']."' AND `team_id` = '$team_id'";
		$GLOBALS['db']->query($sql);
		return true;
		
	}
	public function get_total_statics()
	{
		$sql = "Select Count(*) From ".$GLOBALS['sc']->table('confirms'). " Where `user_id` = '".$this->user_info['user_id']."' ";
		$return['total']['all'] = intval($GLOBALS['db']->getOne($sql));
		$sql = "Select Count(*) From ".$GLOBALS['sc']->table('confirms'). " Where `user_id` = '".$this->user_info['user_id']."' AND `is_rated` = '1'";
		$return['total']['rated'] = intval($GLOBALS['db']->getOne($sql));
		$sql = "Select Count(*) From ".$GLOBALS['sc']->table('confirms'). " Where `user_id` = '".$this->user_info['user_id']."' AND `is_confirmed` = '1'";
		$return['total']['confirmed'] = intval($GLOBALS['db']->getOne($sql));
		return $return;
	}
	public function get_statics()
	{
		$sql = "Select `topic_id`, Count(*) as `total`, Sum(`is_rated`) as `rated`, Sum(`is_confirmed`) as `confirmed` ".
			   "From ".$GLOBALS['sc']->table('confirms'). " Where `user_id` = '".$this->user_info['user_id']."' Group By `topic_id` ";
		$result = $GLOBALS['db']->query($sql);
		while($arr = $GLOBALS['db']->fetchRow($result))
		{
			$return[$arr['topic_id']] = $arr;
			unset($return[$arr['topic_id']]['topic_id']);
		}
		return $return;
	}
	
	public function add_user($user_array)
	{
		if($this->is_admin())
		{
			$sql = "INSERT Into ".$GLOBALS['sc']->table('users').
				   " (`username`,`password`,`salt`, `isadmin`, `role_id`, `sex`, `realname`, `phone`, `comment`) VALUES ".
				   "('".$user_array['username']."',  '".$user_array['password']."',  '".$user_array['salt']."',  '".
				   		$user_array['isadmin']."',  '".$user_array['role_id']."',  '".$user_array['sex']."',  '".
				   		$user_array['realname']."',  '".$user_array['phone']."',  '".$user_array['comment']."')";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $GLOBALS['db']->insert_id();
			return false;
		}
		else return false;
	}
	
	public function add_topic($topic_array)
	{
		if($this->is_admin())
		{
			$sql = "INSERT INTO ".$GLOBALS['sc']->table('topics')." ( `topicname`, `comment`) VALUES ".
				   "( '".$topic_array['topicname']."','".$topic_array['comment']."')";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $GLOBALS['db']->insert_id();
			return false;
		}
		else return false;
	}
	
	public function add_team($team_array)
	{
		if($this->is_admin())
		{
			$sql = "INSERT INTO ".$GLOBALS['sc']->table('teams')." (`team_no`, `teamname`, `comment`, `topic_id`) VALUES ".
				   "('".$team_array['team_no']."', '".$team_array['teamname']."', '".$team_array['comment']."', '".$team_array['topic_id']."')";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $GLOBALS['db']->insert_id();
			return false;
		}
		else return false;
	}
	
	public function add_item($item_array)
	{
		if($this->is_admin())
		{
			$sql = "INSERT INTO ".$GLOBALS['sc']->table('items')." (`topic_id`, `itemname`, `maxscore`, `comment`) VALUES ".
				   "('".$item_array['topic_id']."', '".$item_array['itemname']."', '".$item_array['maxscore']."', '".$item_array['comment']."');";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $GLOBALS['db']->insert_id();
			return false;
		}
		else return false;
	}
	
	public function add_feedback($team_id, $content)
	{
		$sql = "Delete From ".$GLOBALS['sc']->table('feedbacks')." Where `user_id` = '".$this->user_info['user_id']."' AND `team_id` = $team_id ";
		$GLOBALS['db']->query($sql);
		$sql = "Insert INTO ".$GLOBALS['sc']->table('feedbacks')." (`user_id`, `team_id`, `content`) VALUES('".$this->user_info['user_id']."', '$team_id', '$content')";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->insert_id();
	}
	
	public function get_feedback($team_id)
	{
		
		$sql = "Select `content` From ".$GLOBALS['sc']->table('feedbacks')." Where `team_id` = '$team_id' AND `user_id` = '".$this->user_info['user_id']."' LIMIT 1";
		$arr = $GLOBALS['db']->getOne($sql);
		return $arr;
	}

	public function get_feedback_by_id($user_id, $team_id)
	{
		if($this->is_admin())
		{
			$sql = "Select `content` From ".$GLOBALS['sc']->table('feedbacks')." Where `team_id` = '$team_id' AND `user_id` = '".$user_id."' LIMIT 1";
			$arr = $GLOBALS['db']->getOne($sql);
			return $arr;
		}
	}

	public function get_team_scores($team_id)
	{
		$sql = "Select * From ".$GLOBALS['sc']->table('collects')." Where `team_id` = '$team_id' AND `user_id` = '".$this->user_info['user_id']."'";
		$arr = $GLOBALS['db']->getAll($sql);
		return $arr;
	}
	
	public function get_any_team_scores($user_id, $team_id)
	{
		$sql = "Select * From ".$GLOBALS['sc']->table('collects')." Where `team_id` = '$team_id' AND `user_id` = '$user_id'";
		$arr = $GLOBALS['db']->getAll($sql);
		return $arr;
	}
	
	public function get_team_total_scores($team_id)
	{
		$sql = 
				"Select Sum(`score`) ".
				"From ".$GLOBALS['sc']->table('collects')." ".
				"Where `team_id` = '$team_id' AND `user_id` = '".$this->user_info['user_id']."'";
		$arr = $GLOBALS['db']->getOne($sql);
		return $arr;
	}
	
	public function get_any_team_total_scores($user_id ,$team_id)
	{
		$sql =
		"Select Sum(`score`) ".
		"From ".$GLOBALS['sc']->table('collects')." ".
		"Where `team_id` = '$team_id' AND `user_id` = '".$user_id."'";
		$arr = $GLOBALS['db']->getOne($sql);
		return $arr;
	}
 
	public function get_all_users($limit_start = 0,$limit_end = 20)
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('users')." Order By `isadmin` Limit $limit_start, $limit_end";
			$arr = $GLOBALS['db']->getAll($sql);
			return $arr;
		}
		return false;
	}
	
	public function get_all_users_no_admin()
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('users')." Where `isadmin` = 0 Order By `role_id` ";
			$arr = $GLOBALS['db']->getAll($sql);
			return $arr;
		}
		return false;
	}
	
	public function get_all_roles()
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('roles');
			$arr = $GLOBALS['db']->getAll($sql);
			return $arr;
		}
		return false;
	}
	
	public function get_all_privilege()
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('user_privileges') . "" ;
			$arr = $GLOBALS['db']->getAll($sql);
			$ret = Array();
			foreach ($arr as $a)
				$ret[$a['topic_id']][$a['user_id']] = 1;
			return $ret;
		}
		return false;
	}
	
	public function get_privilege_by_user_id($user_id)
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('user_privileges') . " Where `user_id` = '$user_id' " ;
			$arr = $GLOBALS['db']->getAll($sql);
			foreach ($arr as $a)
				$ret[$a['topic_id']] = 1;
			return $ret;
		}
		return false;
	}

	public function get_user_privilege()
	{
		$sql = "Select * From ".$GLOBALS['sc']->table('user_privileges') . " Where `user_id` = '" . $this->user_info['user_id']."' " ;
		$arr = $GLOBALS['db']->getAll($sql);
		foreach ($arr as $a)
			$ret[$a['topic_id']] = 1;
		return $ret;
	}
	
	public function get_user_by_id($user_id)
	{
		if($this->is_admin())
		{
			$sql = "Select * From ".$GLOBALS['sc']->table('users')." Where `user_id` = '$user_id'";
			$arr = $GLOBALS['db']->getRow($sql);
			unset($arr['password']);
			return $arr;
		}
		return false;
	}
	
	public function change_topic($topic_id,$topic_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($topic_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			$set_content = rtrim($set_content,',');
			$sql = 
					"Update  ".$GLOBALS['sc']->table('topics')." ".
					"Set ".$set_content." ".
					"Where `topic_id` = '$topic_id' ";
			$GLOBALS['db']->query($sql);

			if($GLOBALS['db']->affected_rows()==1)
				return $topic_id;
			return false;
		}
		return false;	
	}
	
	public function change_team($team_id, $team_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($team_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			$set_content = rtrim($set_content,',');
			$sql =
				"Update  ".$GLOBALS['sc']->table('teams')." ".
				"Set ".$set_content." ".
				"Where `team_id` = '$team_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $team_id;
			return false;
		}
		return false;
	}
	
	public function change_role($role_id, $role_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($role_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			$set_content = rtrim($set_content,',');
			$sql =
				"Update  ".$GLOBALS['sc']->table('roles')." ".
				"Set ".$set_content." ".
				"Where `role_id` = '$role_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $team_id;
			return false;
		}
		return false;
	}
	
	public function change_item($item_id, $item_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($item_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			$set_content = rtrim($set_content,',');
			$sql =
				"Update  ".$GLOBALS['sc']->table('items')." ".
				"Set ".$set_content." ".
				"Where `item_id` = '$item_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $team_id;
			return false;
		}
		return false;
	}
	
	public function change_user($user_id, $user_array)
	{
		if($this->is_admin() || $user_id == $this->user_info['user_id'])
		{
			if($this->user_info['user_id'] == $user_id)
				return false;
			$set_content = "";
			foreach($user_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}

			$set_content = rtrim($set_content,',');
			$sql =
			"Update ".$GLOBALS['sc']->table('users')." ".
			"Set ".$set_content." ".
			"Where `user_id` = '$user_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return $user_id;
			return false;
		}
		return false;
	}
	public function clear_privilege()
	{
		if(!$this->is_admin())
			return false;
		$GLOBALS['db']->query("Start Transcation");
		$sql = "TRUNCATE ".$GLOBALS['sc']->table("user_privileges");
		$GLOBALS['db']->query($sql);
		return true;
	}
	public function change_privilege($user_id, $topic_array)
	{
		if($this->is_admin())
		{
			//$GLOBALS['db']->query("Start Transcation");
			//$sql = "Delete From ".$GLOBALS['sc']->table("user_privileges")." Where `user_id` = '$user_id'";
			//$GLOBALS['db']->query($sql);
			//$sql = "Delete From ".$GLOBALS['sc']->table("confirms")." Where `user_id` = '$user_id'";
			//$GLOBALS['db']->query($sql);
			$count = 0;
			foreach($topic_array as $key => $value)
			{
				if($value == 1)
				{
					$sql = "Insert Into ".$GLOBALS['sc']->table("user_privileges")." (`user_id`, `topic_id`) VALUES ('$user_id', '$key')";
					$GLOBALS['db']->query($sql);
					$count++;
					$sql = "Select `team_id` From " .$GLOBALS['sc']->table("teams"). " Where `topic_id` = '$key'";
					$result = $GLOBALS['db']->query($sql);
					while($arr = $GLOBALS['db']->fetchRow($result))
					{
						$sql = "Select * From ".$GLOBALS['sc']->table("confirms"). " Where `user_id` = '$user_id' AND `team_id` = '".$arr['team_id']."' LIMIT 1";
						$tarr = $GLOBALS['db']->getRow($sql);
						if(!isset($tarr['user_id']))
						{
							$sql = "Insert Into ".$GLOBALS['sc']->table("confirms"). " (`user_id`, `topic_id`, `team_id`) VALUES ('$user_id', '$key', '".$arr['team_id']."')";
							$GLOBALS['db']->query($sql);
						}
					}
				}
			}
			return $count;
		}
		return false;
	}
	public function finish_privilege()
	{
		if(!$this->is_admin())
			return false;
		if($GLOBALS['db']->errno())
		{
			$GLOBALS['db']->query("Rollback");
			$GLOBALS['db']->query("Commit");
		}
		$GLOBALS['db']->query("Commit");
		return true;
	}
	
	public function delete_team($team_id)
	{
		if($this->is_admin())
		{
			$sql =
				"Delete From ".$GLOBALS['sc']->table('teams')." ".
				"Where `team_id` = '$team_id'";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return true;
			return false;
		}
		return false;
	}
	
	public function delete_role($role_id)
	{
		if($this->is_admin())
		{
			$sql =
			"Delete From ".$GLOBALS['sc']->table('roles')." ".
			"Where `role_id` = '$role_id'";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return true;
			return false;
		}
		return false;
	}
	
	public function delete_item($item_id)
	{
		if($this->is_admin())
		{
			$sql = 
				"Delete From ".$GLOBALS['sc']->table('items')." ".
				"Where `item_id` = '$item_id'";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return true;
			return false;
		}
		return false;
	}
	
	public function delete_user($user_id)
	{
		if($this->is_admin())
		{
			if($this->user_info['user_id'] == $user_id)
				return false;
			$sql =
			"Delete From ".$GLOBALS['sc']->table('users')." ".
			"Where `user_id` = '$user_id'";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows()==1)
				return true;
			return false;
		}
		return false;
	}
	
	public function delete_topic($topic_id)
	{
		if($this->is_admin())
		{
			$sql = 
				"Select `item_id` ".
				"From ".$GLOBALS['sc']->table('items')." ".
				"Where `topic_id` = '$topic_id' ";
			$result = $GLOBALS['db']->query($sql);
			while($arr = $GLOBALS['db']->fetchRow($result))
				$this->delete_item($arr['item_id']);
			$sql = 
				"Delete From ".$GLOBALS['sc']->table('topics')." ".
				"Where `topic_id` = '$topic_id'";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['db']->affected_rows() == 1)
				return true;
			return false;
		}
		return false;
	}
	
	public function logout()
	{
		@session_unset();
	}
	
	private function check_login($username, $password)
	{
		$sql = "Select `user_id`, `password`, `salt` From ".$GLOBALS['sc']->table('users')." Where `username` = '".$username."' LIMIT 1";
		$arr = $GLOBALS['db']->getRow($sql);
		if(isset($arr['password']))
		{
			if(isset($arr['salt']))
				$password = $this->complie_pass($password,$arr['salt']);
			else
				$password = $this->complie_pass($password);
		}
		else return false;
		
		if($arr['password'] == $password)
			return $arr['user_id'];
		else return false;
	}
	
	private function complie_pass($password,$salt = NULL)
	{
		if($salt != NULL)
		{
			return md5(md5($password).$salt);
		}
		else return md5($password);
	}
}

?>
