<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<link type="text/css" rel="stylesheet" href="style.css" />
<title>管理用户</title>
</head>
<body>
<div id="mainContent">
<?php
require_once("classes/class.User.php");
require_once("classes/class.UserPersistence.php");

require("header.php");

echo "<br /><b>用户</b>".' <a target="_blank" href="newuser.php">新建</a>';
$persistence = new UserPersistence();
$users = $persistence->findAll();
echo '<br />已有用户';
echo "<table width='800' border='1' cellpadding='0' cellspacing='0'>";
echo "<tr><td width='95%'> </td><td width='5%'> </td></tr>";
echo "<tr bgcolor='#cccccc'><td>用户名/密码(MD5)</td><td>操作</td></tr>";
foreach($users as $user){
	echo $user->buildTrCode();
}
echo "</table>";

?>
</div>
</body>
</html>