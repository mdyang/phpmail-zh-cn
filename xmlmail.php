<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
header("Content-type: text/xml; charset=gb2312");

require_once("classes/class.MailPersistence.php");
require_once("classes/class.Mail.php");

$tid = $_GET["tid"];
$persistence = new MailPersistence();
$mail = $persistence->find($tid);
echo $mail->exportXML();
?>