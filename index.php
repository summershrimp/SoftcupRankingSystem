<?php
define('IN_SCRS','true');

require_once './includes/init.inc.php';

if(isset($_GET['act'])&&$_GET['act']=='login')
	$user->login($_POST['uname'],$_POST['pass']);


if(!$user->is_login())
{
	relocate("login.php");
}
elseif($user->is_admin())
relocate("admin/index.php");
else
	relocate("topic.php");




?>


