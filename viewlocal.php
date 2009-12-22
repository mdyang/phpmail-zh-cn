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
<title>预览</title>
</head>
<body>
<div id="mainContent" style="background:#fff">
<?php
require_once("classes/class.Entity.php");
require_once("classes/class.MailPersistence.php");
require_once("classes/class.Mail.php");
require_once("classes/class.TemplatePersistence.php");
require_once("classes/class.Template.php");
require_once("classes/class.CardTemplatePersistence.php");
require_once("classes/class.CardTemplate.php");

require("header.php");

$mode = $_GET["mode"];

if ($mode == "mail"){
	$tid = $_GET["tid"];
	$persistence = new MailPersistence();
	$mail = $persistence->find($tid);
	echo $mail->getContent();
}

if ($mode == "template"){
	$tid = $_GET["tid"];
	$persistence = new TemplatePersistence();
	$template = $persistence->find($tid);
	echo $template->getContent();
}

if ($mode == "cardtmpl"){
	$tid = $_GET["tid"];
	echo '<img src="cardtmpl/'.$tid.'/image.img" />';
}

?>
</div>
</body>
</html>