<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<title>建立新用户</title>
</head>
<body>
<?php 
require_once("classes/class.User.php");
require_once("classes/class.UserPersistence.php");
 
$persistence = new UserPersistence();

$user = new User();
$user->setTid($_POST["username"]);
$user->setPassword($_POST["password"]);

if ($persistence->create($user)){
	echo "用户创建成功";
}
else{
	echo "用户名已存在";
}
?>
</body>
</html>
