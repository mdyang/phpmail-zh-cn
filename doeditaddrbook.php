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
<title>新地址簿</title>
</head>
<body>
<?php 
require_once("classes/class.AddressBook.php");
require_once("classes/class.AddressBookPersistence.php");
 
$persistence = new AddressBookPersistence();

$addr = new AddressBook();
$addr->setTid($_GET["tid"]);
$addr->setName($_POST["name"]);
$addr->setContent($_POST["content"]);

$persistence->create($addr);

header("Location:manageaddrbook.php");
?>
</body>
</html>
