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
<title>�ʼ�Ⱥ��ϵͳ</title>
</head>
<body>
<div id="mainContent">
<?php
require_once("classes/class.Utility.php");
require_once("classes/class.Mail.php");
require_once("classes/class.MailPersistence.php");

require("header.php");

echo '<br /><b>�ʼ�</b> ';
echo '<a href="compose.php?action=create">����</a> ';
echo '<a href="uploadzipmail.php">�ϴ�ZIPѹ����</a> ';
echo '<a href="composecard.php">׫д����Ƭ</a> ';
$mailPersistence = new MailPersistence();
$mails = $mailPersistence->findAll();
echo '<br />��ʷ�ʼ�';
echo "<table width='850' border='1' cellpadding='0' cellspacing='0'>";
echo "<tr><td width='85%'> </td><td width='5%'> </td><td width='5%'> </td><td width='5%'> </td></tr>";
echo "<tr bgcolor='#cccccc'><td>����(�����Ԥ��)</td><td>����</td></tr>";
foreach($mails as $mail){
	echo $mail->buildTrCode();
}
echo "</table>";

?>
</div>
</body>
</html>