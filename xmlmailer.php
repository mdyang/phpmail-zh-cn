<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
header("Content-type: text/plain; charset=gb2312");

require_once("classes/class.Mail.php");
require_once("classes/class.MailPersistence.php");
require_once("classes/class.SmtpConfig.php");
require_once("classes/class.SmtpConfigPersistence.php");
require_once("classes/class.Mailer.php");
require_once("classes/class.Utility.php");

//$smtpid = "1257903122.0955";//$_POST["smtpid"];
//$mailtid = "1258528367.4795";//$_POST["mailtid"];
//$to = "yangmengdong@aigindustries.com.cn";//$_POST["to"];
//$cc = "";//$_POST["cc"];
//$bcc = "";//$_POST["bcc"];
$smtpid = $_POST["smtpid"];
$mailtid = $_POST["mailtid"];
$to = $_POST["to"];
$cc = $_POST["cc"];
$bcc = $_POST["bcc"];

$to = Utility::genEmailListFromStr($to);
$cc = Utility::genEmailListFromStr($cc);
$bcc = Utility::genEmailListFromStr($bcc);

$smtpPersistence = new SmtpConfigPersistence();
$smtp = $smtpPersistence->find($smtpid);

$mailPersistence = new MailPersistence();
$mail = $mailPersistence->find($mailtid);

Mailer::send(array(
	"mail"	=> $mail->getInfo(),
	"smtp"	=> $smtp->getInfo(),
	"to"	=> $to,
	"cc"	=> $cc,
	"bcc"	=> $bcc,
	"image"	=> array(),
	"files"	=> $mail->getFilelist()
));


?>