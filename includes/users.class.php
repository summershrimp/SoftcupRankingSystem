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
	
	public function add_collects($topic_id,$team_id,$collects)
	{
		if(!$this->is_login())
			return false;
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
			$sql = "DELETE From ".$GLOBALS['sc']->table('collects')." Where `user_id` = '".$this->user_info['user_id']."' AND `topic_id` = '".$topic_id."' AND `team_id` = '$team_id'";
			$GLOBALS['db']->query($sql);
			return false;
		}
		return true;
		
	}
	
	public function add_user($user_array)
	{
		if($this->is_admin())
		{
			$sql = "INSERT Into ".$GLOBALS['sc'].table('users').
				   " (`username`,`password`,`salt`,`isadmin`,`sex`,`realname`,`phone`,`comment`) VALUES ".
				   "('".$user_array['username']."',  '".$user_array['password']."',  '".$user_array['salt']."',  '".
				   		$user_array['isadmin']."',  '".$user_array['sex']."',  '".$user_array['realname']."',  '".
				   		$user_array['phone']."',  '".$user_array['comment']."')";
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
			$sql = "INSERT INTO ".$GLOBALS['sc']->table('teams')." (`teamname`, `comment`, `topic_id`) VALUES ".
				   "('".$team_array['teamname']."', '".$team_array['comment']."', '".$team_array['topic_id']."')";
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
	
	public function get_team_scores($team_id)
	{
		$sql = "Select * From ".$GLOBALS['sc']->table('collects')." Where `team_id` = '$team_id' AND `user_id` = '".$this->user_info['user_id']."'";
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

	public function change_topic($topic_id,$topic_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($topic_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			rtrim($set_content,',');
			$sql = 
					"Update From ".$GLOBALS['sc']->table('topics')." ".
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
			rtrim($set_content,',');
			$sql =
				"Update From ".$GLOBALS['sc']->table('teams')." ".
				"Set ".$set_content." ".
				"Where `team_id` = '$team_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['sb']->affected_rows()==1)
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
			rtrim($set_content,',');
			$sql =
				"Update From ".$GLOBALS['sc']->table('roles')." ".
				"Set ".$set_content." ".
				"Where `role_id` = '$role_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['sb']->affected_rows()==1)
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
			rtrim($set_content,',');
			$sql =
				"Update From ".$GLOBALS['sc']->table('items')." ".
				"Set ".$set_content." ".
				"Where `item_id` = '$item_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['sb']->affected_rows()==1)
				return $team_id;
			return false;
		}
		return false;
	}
	
	public function change_user($user_id, $user_array)
	{
		if($this->is_admin())
		{
			$set_content = "";
			foreach($user_array as $key => $value)
			{
				$set_content .= "`$key` = '$value',";
			}
			rtrim($set_content,',');
			$sql =
			"Update From ".$GLOBALS['sc']->table('users')." ".
			"Set ".$set_content." ".
			"Where `user_id` = '$user_id' ";
			$GLOBALS['db']->query($sql);
			if($GLOBALS['sb']->affected_rows()==1)
				return $team_id;
			return false;
		}
		return false;
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
