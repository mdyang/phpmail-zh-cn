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
<title>管理员登录</title>
</head>
<body>
<?php 
require_once("classes/class.Admin.php");
require_once("classes/class.AdminPersistence.php");

$username = $_POST["username"];
$password = $_POST["password"];

$persistence = new AdminPersistence();
$user = $persistence->find($username);

if ($user!=null && $user->getPassword()==md5($password)){
	
	$_SESSION["logged"] = true;
	$_SESSION["type"] = "admin";
	$_SESSION["username"] = $username;

	if (isset($_SESSION["redirect"])){
		$url = $_SESSION["redirect"];
		$_SESSION["redirect"] = null;
		header("Location: ".$url);
	}
	else{
		header("Location: index.php");
	}
}
else{
	echo "用户名/密码错误，请返回";
}
?>
</body>
</html>
