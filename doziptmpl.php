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
<title>Save ZipMail</title>
</head>
<body>
<?php 
require_once("classes/class.Template.php");
require_once("classes/class.TemplatePersistence.php");

$tid = $_GET["tid"];
$name = $_POST["name"];
$action = $_GET["action"];

$upfile = &$_FILES['filepath'];
$dstpath = "template/".$tid;
$_files = $dstpath."/_files";
if (!is_dir($dstpath)){
	mkdir($dstpath);
	mkdir($dstpath."/attachments");
	mkdir($dstpath."/images");
	mkdir($_files);
}
Utility::writeFile($dstpath."/name.txt", $name);
$dstfile = $dstpath."/_files/__mail.zip";
$upTemp = move_uploaded_file($upfile['tmp_name'],$dstfile);
Utility::unzip($dstfile, $dstpath);
$filelist = Utility::listFilesOnly($_files);

$persistence = new TemplatePersistence();
$mail = $persistence->find($tid);
$content = $mail->getContent();
foreach($filelist as $file){
	$content = str_ireplace("_files/".$file, "template/".$tid."/_files/".$file, $content);
}
$mail->setContent($content);
$persistence->update($mail);

if ($action == "save"){
	header("Location:index.php");
}
else{
	header("Location:presend.php?redirect=dosend.php&tid=".$tid);
}

?>
</body>
</html>
