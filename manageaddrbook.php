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
<title>地址簿</title>
</head>
<body>
<div id="mainContent">
<?php
require_once("classes/class.Entity.php");
require_once("classes/class.AddressBook.php");
require_once("classes/class.AddressBookPersistence.php");

require("header.php");

echo "<br /><b>地址簿</b>".' <a target="_blank" href="editaddrbook.php?action=create">添加</a>';
$persistence = new AddressBookPersistence();
$books = $persistence->findAll();
echo '<br />已有地址';
echo "<table width='800' border='1' cellpadding='0' cellspacing='0'>";
echo "<tr><td width='95%'> </td><td width='5%'> </td></tr>";
echo "<tr bgcolor='#cccccc'><td>名称(点击查看/修改)</td><td>操作</td></tr>";
foreach($books as $book){
	echo $book->buildTrCode();
}
echo "</table>";

?>
</div>
</body>
</html>