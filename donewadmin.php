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
<title>�����¹���Ա</title>
</head>
<body>
<?php 
require_once("classes/class.Admin.php");
require_once("classes/class.AdminPersistence.php");
 
$persistence = new AdminPersistence();

$admin = new Admin();
$admin->setTid($_POST["username"]);
$admin->setPassword($_POST["password"]);

if ($persistence->create($admin)){
	echo "����Ա�����ɹ�";
}
else{
	echo "�û����Ѵ���";
}
?>
</body>
</html>
