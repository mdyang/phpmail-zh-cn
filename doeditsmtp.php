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
<title>新邮件</title>
</head>
<body>
<?php 
require_once("classes/class.SmtpConfig.php");
require_once("classes/class.SmtpConfigPersistence.php");
 
$persistence = new SmtpConfigPersistence();

$smtp = new SmtpConfig();
$smtp->setTid($_GET["tid"]);
$smtp->setEmail($_POST["email"]);
$smtp->setHost($_POST["host"]);
$smtp->setPort($_POST["port"]);
$smtp->setDisplayName($_POST["displayName"]);
$smtp->setUsername($_POST["username"]);
$smtp->setPassword($_POST["password"]);

$persistence->create($smtp);

header("Location:managesmtp.php");
?>
</body>
</html>
