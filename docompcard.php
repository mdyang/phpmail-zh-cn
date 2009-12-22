<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>新明信片</title>
</head>
<body>
<?php 
require_once("classes/class.Utility.php");
require_once("classes/class.Mail.php");
require_once("classes/class.MailPersistence.php");

$tid = $_GET["tid"];
$subject = $_POST["subject"];
$action = $_GET["action"];
$image = $_POST["image"];
$image = base64_decode($image);

$path = "upload/".$tid;
$imagePath = $path."/_files";
$theImagePath = $imagePath."/_image.img";

mkdir($path);
mkdir($imagePath);
Utility::writeFile($theImagePath, $image);

$mail = new Mail();
$persistence = new MailPersistence();

$mail->setTid($tid);
$mail->setSubject($subject);
$mail->setContent('<img src="'.$theImagePath.'" />');

$persistence->create($mail);

if ($action == "send"){
	header("Location: presend.php?redirect=dosend.php&tid=".$tid);
}
else{
	header("Location: index.php");
}

?>
</body>
</html>
