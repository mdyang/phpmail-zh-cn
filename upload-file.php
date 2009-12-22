<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Upload File</title>
</head>
<body>
<form action="upload-file.php?tid=<?php echo $_GET["tid"];?>" method="post" enctype="multipart/form-data" name="form1">
  <input name="filepath" type="file" id="pic" />
  <input type="submit" name="Submit" value="提交" />
  <input name="action" type="hidden" id="action" value="uploadfile" />
</form>
<?php

require_once("classes/class.Utility.php");

if (!empty($_FILES)){
	$tid = $_GET["tid"];
	$upfile = &$_FILES['filepath'];
	$fname = $upfile['name'];
	$dstpath = Utility::getAbsolutePathRel("upload/".$tid);
	if (!is_dir($dstpath)){
		mkdir($dstpath);
		mkdir($dstpath."/attachments");
		mkdir($dstpath."/images");
	}
	$pic = $dstpath."/attachments/".$fname;
	$upTemp = move_uploaded_file($upfile['tmp_name'],$pic);
	if ($upTemp){
		echo "<script language='javascript'>parent.complete_file_upload('success', '".$fname."');</script>";
	}else{
		echo "<script language='javascript'>parent.complete_file_upload('failed', '');</script>";
	}
//	}
}
?>
</body>
</html>