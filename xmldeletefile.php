<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
header("Content-type: text/plain; charset=gb2312");

$file = $_POST["file"];

if (unlink($file)){
	echo "succeed";
}
else{
	echo "failed";
}

?>