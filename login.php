<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<title>登录</title>
</head>
<body>
<div id="mainContent">
<?php
require("header.php"); 
?>
	<form id="form1" method="post" action="dologin.php">
		<input type="button" onclick="save()" value="登录" /><br />
		用户名<br />
		<input type="text" id="username" name="username" style="width:400px" /><br />
		密码<br />
		<input type="password" id="password" name="password" style="width:400px" /><br />
	</form>
</div>
<script>

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
