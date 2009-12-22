<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require_once("classes/class.Utility.php");
require_once("classes/class.SmtpConfig.php");
require_once("classes/class.SmtpConfigPersistence.php");

$action = $_GET["action"];
$tid = '0';

if ($action == "create"){
	$tid = Utility::getTimeMills();
}
else{
	$tid = $_GET["tid"];
}

$persistence = new SmtpConfigPersistence();
$entity = $persistence->find($tid);
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<title>SMTP����ʽ</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="doeditsmtp.php?tid=<?php echo $tid;?>">
		<input type="button" onclick="save()" value="����" /><br />
		Email��ַ<br />
		<input id="email" name="email" value="<?php echo Entity::getField($entity, "email")?>" style="width:400px" /><br />
		��ʾ��<br />
		<input id="displayName" name="displayName" value="<?php echo Entity::getField($entity, "displayName")?>" style="width:400px" /><br />
		SMTP��������ַ<br />
		<input id="host" name="host" value="<?php echo Entity::getField($entity, "host")?>" style="width:400px" /><br />
		�˿�<br />
		<input id="port" name="port" value="<?php echo Entity::getField($entity, "port")?>" style="width:400px" /><br />
		�û���<br />
		<input id="username" name="username" value="<?php echo Entity::getField($entity, "username")?>" style="width:400px" /><br />
		����<br />
		<input id="password" name="password" value="<?php echo Entity::getField($entity, "password")?>" style="width:400px" /><br />
	</form>
</div>
<script>
var tid = "<?php echo $tid;?>";
var new_smtp = <?php echo ($action=="create")?"true":"false";?>;

function get_form(){
	return document.getElementById("form1");
}

function save(){
	$(get_form()).submit();
}

$(document).ready(function(){
});

</script>
</body>
</html>
