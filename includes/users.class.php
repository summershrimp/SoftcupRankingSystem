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
		setcookie($GLOBALS['sc']->table("username"),$username,0,"/");
		setcookie($GLOBALS['sc']->table("password"),$password,0,"/");
		if($user_id = $this->check_login($username, $password))
		{
			if(!isset($_SESSION['user_id']))
			{
				session_start();
			}
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
		if(isset($_COOKIE[$GLOBALS['sc']->table("username")])&&isset($_COOKIE[$GLOBALS['sc']->table("password")]))
			$this->login($_COOKIE[$GLOBALS['sc']->table("username")],$_COOKIE[$GLOBALS['sc']->table("password")]);
		if(isset($_SESSION['user_id']))
			return true;
		return false;
	}
	
	public function add_collects($topic_id,$team_id,$collects)
	{
		if(!$this->is_login())
			return false;
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
				return true;
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
				return true;
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
				return true;
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
				return true;
			return false;
		}
		else return false;
	}
	
	public function logout()
	{
		@session_unset();
		@session_destroy();
		setcookie($GLOBALS['sc']->table("username"),NULL,time()-3600,"/");
		setcookie($GLOBALS['sc']->table("password"),NULL,time()-3600,"/");
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
