<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>新模板</title>
</head>
<body>
<?php 
require_once("classes/class.Utility.php");
require_once("classes/class.CardTemplate.php");
require_once("classes/class.CardTemplatePersistence.php");

if (empty($_FILES)){
	Utility::alert("请指定上传文件");
	echo "<script language='javascript'>window.history.go(-1);</script>";
}
else{
	$tid = $_GET["tid"];
	$upfile = &$_FILES['filepath'];
	$fname = $upfile['name'];
	$dstpath = Utility::getAbsolutePathRel("cardtmpl/".$tid);
	if (!is_dir($dstpath)){
		mkdir($dstpath);
	}
	$pic = $dstpath."/image.img";
	$upTemp = move_uploaded_file($upfile['tmp_name'],$pic);
	if ($upTemp){
		$tid = $_GET["tid"];
		$name = $_POST["name"];
		
		$persistence = new CardTemplatePersistence();
		
		$entity = new CardTemplate();
		$entity->setTid($tid);
		$entity->setName($name);
		
		$persistence->create($entity);
		
		header("Location:index.php");
	}else{			
		Utility::alert("上传失败，请重试");
		echo "<script language='javascript'>window.history.go(-1);</script>";
	}
}

?>
</body>
</html>
