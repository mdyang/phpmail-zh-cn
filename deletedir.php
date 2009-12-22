<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
require_once("classes/class.Utility.php");

Utility::deleteDir($_GET["dir"]);

header("Location: ".$_GET["redirect"]);
?>