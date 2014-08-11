<?php
	if (!defined("IN_SCRS")) exit();
?>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no,width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" href="css/common.css">
<?php
	if ($user->is_login() && $user->is_admin()) {
		echo "<link rel=\"stylesheet\" href=\"css/admin.css\">";
	}
?>