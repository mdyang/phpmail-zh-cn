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
require_once("classes/class.AddressBook.php");
require_once("classes/class.AddressBookPersistence.php");

$action = $_GET["action"];
$tid = '0';

if ($action == "create"){
	$tid = Utility::getTimeMills();
}
else{
	$tid = $_GET["tid"];
}

$persistence = new AddressBookPersistence();
$entity = $persistence->find($tid);
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<title>编辑地址簿</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="doeditaddrbook.php?tid=<?php echo $tid;?>">
		<input type="button" onclick="save()" value="保存" /><br />
		名称<br />
		<input id="name" name="name" value="<?php echo Entity::getField($entity, "name")?>" style="width:400px" /><br />
		地址 (地址间以";(半角分号)"或",(半角逗号)"隔开)<br />
		<textarea id="content" name="content" style="width:900px;height:500px"><?php echo Entity::getField($entity, "content")?></textarea><br />
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
