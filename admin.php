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
<title>管理</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
<a href="manageaddrbook.php">地址簿</a> 
<a href="managecardtmpl.php">明信片模板管理</a> 
<a href="managetmpl.php">信纸管理</a> 
<a href="managesmtp.php">SMTP配制式管理</a> 
<a href="manageuser.php">用户管理</a> 
<a href="manageadmin.php">管理员管理</a> 

</div>
</body>
</html>