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
<title>管理SMTP配制式</title>
</head>
<body>
<div id="mainContent">
<?php
require_once("classes/class.Entity.php");
require_once("classes/class.SmtpConfig.php");
require_once("classes/class.SmtpConfigPersistence.php");

require("header.php");

echo "<br /><b>SMTP配制式</b>".' <a href="editsmtp.php?action=create">创建</a>';
$smtpPersistence = new SmtpConfigPersistence();
$smtps = $smtpPersistence->findAll();
echo '<br />已有SMTP配制式';
echo "<table width='800' border='1' cellpadding='0' cellspacing='0'>";
echo "<tr><td width='90%'> </td><td width='5%'> </td><td width='5%'> </td></tr>";
echo "<tr bgcolor='#cccccc'><td>配制式信息</td><td>操作</td></tr>";
foreach($smtps as $smtp){
	echo $smtp->buildTrCode();
}
echo "</table>";

?>
</div>
</body>
</html>