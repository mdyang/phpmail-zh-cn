<?php

/**
 * Authentication Module
 */

require_once("classes/function.authenticator.php");

//echo $_SESSION["logged"]."<br />";
//echo $_SESSION["username"]."<br />";
//echo $_SESSION["type"]."<br />";

if (!authenticate($_cur_auth_settings, $_cur_auth_params)){
	$_SESSION["redirect"] = $_cur_page_file;
	header("Location: ".$_cur_auth_settings[0]["action"]["redirect"]);
}

?>