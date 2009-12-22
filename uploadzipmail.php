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
$tid = Utility::getTimeMills();
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<title>上传Zip邮件</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="dozipmail.php?tid=<?php echo $tid;?>" enctype="multipart/form-data">
		<input type="button" value="发送" onclick="send()" />
		<input type="button" value="保存" onclick="save()" /><br />
		主题<br />
		<input name="subject" type="text" style="width:800px" /><br />
		请选择Zip文件<br /> 
		<input name="filepath" type="file" id="filepath" /><br />
		对于Zip文件有一定的要求，如果您不了解，请阅读<a target="_blank" href="static/zipmail_spec.htm">Zip邮件规范</a>

	</form><br />
</div>
<script language="javascript">
function send(){
	var theForm = $("#form1");
	theForm
		.attr("action", theForm.attr("action")+"&action=send")
		.submit();
}
function save(){
	var theForm = $("#form1");
	theForm
		.attr("action", theForm.attr("action")+"&action=save")
		.submit();
}
</script>
</body>
</html>
