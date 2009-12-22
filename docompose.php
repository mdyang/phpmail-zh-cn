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
require_once("classes/class.Mail.php");
require_once("classes/class.MailPersistence.php");
 
$subject = $_POST["subject"];
$content = $_POST["content"];
$action = $_GET["action"];
$tid = $_GET["tid"];

$persistence = new MailPersistence();

$mail = new Mail();
$mail->setTid($tid);
$mail->setSubject($subject);
$mail->setContent($content);

$persistence->create($mail);

if ($action == "send"){
	header("Location:presend.php?redirect=dosend.php&tid=".$tid);
}
else{
	header("Location:index.php");
}
?>
</body>
</html>
