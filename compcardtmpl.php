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

require("header.php");

$tid = Utility::getTimeMills();	
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<title>�ϴ�ģ��</title>
</head>
<body>
<div id="mainContent">
	<form id="form1" method="post" enctype="multipart/form-data" action="docompcardtmpl.php?tid=<?php echo $tid;?>">
		<input type="submit" value="�ϴ�" /><br />
		ģ������:<br />
		<input name="name" type="text" style="width:600px" /><br />
		ģ���ļ�:<br />
  		<input name="filepath" type="file" id="pic" /><br />
		��������Ƭģ���ļ���һ����Ҫ����������˽⣬���Ķ�<a target="_blank" href="static/card_tmpl_spec.htm">����Ƭģ��淶</a>
</div>
</body>
</html>
