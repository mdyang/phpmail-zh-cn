<?php

class Convertor{
	
	public static function convertImages($content, $tid){
		return str_ireplace("upload/".$tid."/images/", "././images/", $content);
	}

	public static function unconvertImages($content, $tid){
		return str_ireplace("././images/", "upload/".$tid."/images/", $content);
	}
}

?>