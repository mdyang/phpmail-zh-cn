<?php
header("Content-type: text/xml; charset=gb2312");

require_once("classes/class.Mailer.php");

$tid = $_GET["tid"];
$persistence = new MailPersistence();
$mail = $persistence->find($tid);
echo $mail->exportXML();
?>