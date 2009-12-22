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

$mailtid = $_GET["tid"];
$smtpid = $_POST["smtp"];
$onceto = $_POST["onceto"];
$oncecc = $_POST["oncecc"];
$oncebcc = $_POST["oncebcc"];
$oncesize = $_POST["oncesize"];
$manyto = $_POST["manyto"];
$manycc = $_POST["manycc"];
$manybcc = $_POST["manybcc"];

$oncesize = trim($oncesize);
if ($oncesize == ""){
	$oncesize = 100;
}
else{
	$oncesize = (integer)$oncesize;
}

$onceto = Utility::genEmailListFromStr($onceto);
$oncecc = Utility::genEmailListFromStr($oncecc);
$oncebcc = Utility::genEmailListFromStr($oncebcc);
$manyto = Utility::genEmailListFromStr($manyto);
$manycc = Utility::genEmailListFromStr($manycc);
$manybcc = Utility::genEmailListFromStr($manybcc);

$onceContainer = array(
	"to"	=>	$onceto,
	"cc"	=>	$oncecc,
	"bcc"	=>	$oncebcc
);

$onceKeys = array("to", "cc", "bcc");

$receiver = array();

$curReceiver = getPseudoEmptyInitAddressList($manyto, $manycc, $manybcc);

$reserveSize = count($manyto) + count($manycc) + count($manybcc);
$size = $oncesize - $reserveSize;

$iTo = 0;
$iCc = 0;
$iBcc = 0;

$maxTo = count($onceto);
$maxCc = count($oncecc);
$maxBcc = count($oncebcc);

$count = $size;

foreach($onceKeys as $key){
	$curOnceList = $onceContainer[$key];
	foreach($curOnceList as $once){
		$curReceiver[$key][] = $once;
		if (--$count == 0){
			$receiver[] = $curReceiver;
			$curReceiver = getPseudoEmptyInitAddressList($manyto, $manycc, $manybcc);
			$count = $size;
		}
	}
}
if ($count < $size){
	$receiver[] = $curReceiver;
}

echo '<script language="javascript" type="text/javascript">';
echo 'var mailtid = "'.$mailtid.'";';
echo 'var smtpid = "'.$smtpid.'";';
echo 'var addressList=';
$declarationStr = array();
foreach($receiver as $rec){
	$recDeclarationStr = Utility::strMapToJSDeclaration(array(
		"to"	=>	Utility::arrayToJSStr($rec["to"]),
		"cc"	=>	Utility::arrayToJSStr($rec["cc"]),
		"bcc"	=>	Utility::arrayToJSStr($rec["bcc"])
	));
	$declarationStr[] = $recDeclarationStr;
}
echo Utility::arrayToJSDeclaration($declarationStr);
echo ';';
echo '</script>';

function getPseudoEmptyInitAddressList($manyto, $manycc, $manybcc){
	$return = array(
		"to"	=>	array(),
		"cc"	=>	array(),
		"bcc"	=>	array()
	);
	foreach($manyto as $to){
		$return["to"][] = $to;
	}
	foreach($manycc as $cc){
		$return["cc"][] = $cc;
	}
	foreach($manybcc as $bcc){
		$return["bcc"][] = $bcc;
	}
	return $return;
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/asyncsender.js"></script>
<title>正在发送邮件</title>
</head>
<body style="text-align:left;font:Calibri 宋体">
<?php 
require("header.php");
?>
发送进度：<br />
<div id="progressBarContainer" style="border:solid 1px #000;width:200px;height:20px;padding:0px;background:#fff">
	<div id="progressBar" style="padding:0px;background:#000;width:0px;height:20px">
	</div>
</div>
<div id="eventMessageContainer">
	<div>发送详情</div>
	<div id="eventMessageHeader"></div>
</div>
</body>
</html>
