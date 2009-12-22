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
<title>管理信纸</title>
</head>
<body>
<div id="mainContent">
<?php
require_once("classes/class.Entity.php");
require_once("classes/class.Template.php");
require_once("classes/class.TemplatePersistence.php");

require("header.php");

echo "<br /><b>信纸</b>".' <a target="_blank" href="uploadziptmpl.php">上传</a>';
$persistence = new TemplatePersistence();
$templates = $persistence->findAll();
echo '<br />已有信纸';
echo "<table width='800' border='1' cellpadding='0' cellspacing='0'>";
echo "<tr><td width='95%'> </td><td width='5%'> </td></tr>";
echo "<tr bgcolor='#cccccc'><td>信纸名称(点击预览)</td><td>操作</td></tr>";
foreach($templates as $template){
	echo $template->buildTrCode();
}
echo "</table>";

?>
</div>
</body>
</html>