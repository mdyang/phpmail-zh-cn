<?php

class Utility{

	public static function getTimeMills(){
		list($msec, $sec) = explode(" ", microtime());
		$mills = $msec + $sec;
		return $mills;
	}

	public static function alert($content){
		echo "<script language='javascript'>alert('$content');</script>";
	}

	public static function getAbsolutePath(){
		$curPath = dirname(__FILE__)."/..";
		return str_ireplace("\\", "/", $curPath);
	}

	public static function getAbsolutePathRel($rel){
		$curPath = dirname(__FILE__)."/..";
		return str_ireplace("\\", "/", $curPath)."/".$rel;
	}

	public static function getRealtimeAbsolutePath(){
		$curPath = realpath(".");
		return str_ireplace("\\", "/", $curPath);
	}

	public static function getRealtimeAbsolutePathRel($rel){
		$curPath = realpath(".");
		return str_ireplace("\\", "/", $curPath)."/".$rel;
	}

	public static function readFile($filepath){
		$size = filesize($filepath);
		$file = fopen($filepath, "r");
		$content = fread($file, $size);
		fclose($file);
		return $content;
	}

	public static function writeFile($filepath, $content){
		$file = fopen($filepath, "w+");
		fwrite($file, $content);
		fclose($file);
	}

	public static function listFiles($path, $order = 1){
		$return = array();
		$i = 0;

		$files = null;
		if ($order == 1) $files = scandir($path);
		else $files = scandir($path, 1);
		foreach($files as $file){
			if ($file=="." || $file=="..") continue;
			$return[$i++] = $file;
		}

		return $return;
	}

	public static function listFilesOnly($path, $order = 1){
		$return = array();
		$i = 0;

		$files = null;
		if ($order == 1) $files = scandir($path);
		else $files = scandir($path, 1);
		foreach($files as $file){
			if (is_dir(Utility::getAbsolutePathRel($path."/".$file))) continue;
			$return[$i++] = $file;
		}

		return $return;
	}

	public static function deleteDir($dir){
		return delete_directory($dir);
	}

	public static function genEmailListFromStr($str){
		$str = trim($str);
		if ($str == "") return array();
		$replacer = array(
			"	" => "",
			" " => "",
			"\"" => "",
			"'" => "",
			"`" => "",
			"\n" => ";",
			"," => ";",
			"|" => ";",
			":" => ";"
			);
			$delim = ";";

		foreach ($replacer as $k => $v){
			$str = str_ireplace($k, $v, $str);
		}

		$returnTemp = explode($delim, $str);
		$return = array();
		foreach ($returnTemp as $addr){
			if (trim($addr) != ""){
				$return[]  = $addr;
			}
		}
		
		return $return;
	}

	public static function unzip($file, $destination){

		$zip=zip_open(realpath(".")."/".$file);
		if(!$zip) {return("Unable to proccess file '{$file}'");}

		$e='';

		while($zip_entry=zip_read($zip)) {
			$zdir=$destination."/".dirname(zip_entry_name($zip_entry));
			$zname=$destination."/".zip_entry_name($zip_entry);

			if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
			if(!is_dir($zdir)) mkdirr($zdir,0777);

			$zip_fs=zip_entry_filesize($zip_entry);
			if(empty($zip_fs)) continue;

			$zz=zip_entry_read($zip_entry,$zip_fs);

			$z=fopen($zname,"w");
			fwrite($z,$zz);
			fclose($z);
			zip_entry_close($zip_entry);

		}
		zip_close($zip);

		return($e);
	}

	public static function strArrayToJSDeclaration($array){
		$return = '[';
		$count = count($array);
		for ($i = 0; $i < $count; $i ++){
			$return .= '"';
			$return .= $array[$i];
			$return .= '"';
			if ($i < $count-1){
				$return .= ",";
			}
		}
		$return .= "]";
		return $return;
	}
	
	public static function arrayToJSDeclaration($array){
		$return = '[';
		$count = count($array);
		for ($i = 0; $i < $count; $i ++){
			$return .= $array[$i];
			if ($i < $count-1){
				$return .= ",";
			}
		}
		$return .= "]";
		return $return;
	}
	
	public static function arrayToJSStr($array){
		$return = '"';
		$count = count($array);
		for ($i = 0; $i < $count; $i ++){
			$return .= $array[$i];
			if ($i < $count-1){
				$return .= ";";
			}
		}
		$return .= '"';
		return $return;
	}
	
	public static function strMapToJSDeclaration($map){
		$return = '{';
		$count = count($map);
		$i = 0;
		foreach($map as $key=>$value){
		
			$return .= '"';
			$return .= $key;
			$return .= '":';
			$return .= $value;
			if ($i < $count-1){
				$return .= ",";
			}
			
			$i ++;
		}
		$return .= "}";
		return $return;
	}
	
	public static function strMapToStrJSDeclaration($map){
		$return = '{';
		$count = count($map);
		$i = 0;
		foreach($map as $key=>$value){
		
			$return .= '"';
			$return .= $key;
			$return .= '":"';
			$return .= $value;
			$return .= '"';
			if ($i < $count-1){
				$return .= ",";
			}
			
			$i ++;
		}
		$return .= "}";
		return $return;
	}
	
	public static function curFile(){	
		$url = $_SERVER['PHP_SELF'];
		$filename = end(explode('/',$url));
		return $filename;
	}

}
function mkdirr($pn,$mode=null) {

	if(is_dir($pn)||empty($pn)) return true;
	$pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);

	if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}

	$next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
	if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
	return false;
}

function delete_directory($dirname) {
	if (is_dir($dirname))
	$dir_handle = opendir($dirname);
	if (!$dir_handle)
	return false;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
			unlink($dirname."/".$file);
			else
			delete_directory($dirname.'/'.$file);
		}
	}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}

?>