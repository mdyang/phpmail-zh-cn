<?php

require_once("interface.AbstractPersistence.php");
require_once("class.SmtpConfig.php");
require_once("class.Utility.php");

class SmtpConfigPersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("smtp");
	}

	public function create($entity){
		
		$tid = $entity->getTid();
		$dir = $this->path."/".$tid;
		if (!is_dir($dir)){
			mkdir($dir);
		}
		
		Utility::writeFile($dir."/host", $entity->getHost());
		Utility::writeFile($dir."/port", $entity->getPort());
		Utility::writeFile($dir."/email", $entity->getEmail());
		Utility::writeFile($dir."/username", $entity->getUsername());
		Utility::writeFile($dir."/password", $entity->getPassword());
		Utility::writeFile($dir."/displayName", $entity->getDisplayName());
		
	}

	public function update($entity){
		$this->create($entity);
	}

	public function delete($tid){
		Utility::deleteDir($this->path.$tid);
	}

	public function find($tid){
		$dir = $this->path."/".$tid;
		$return = array("tid"=>$tid);
		if (!is_dir($dir)) return null;		
		
		$return["host"] = Utility::readFile($dir."/host");
		$return["port"] = Utility::readFile($dir."/port");
		$return["email"] = Utility::readFile($dir."/email");
		$return["username"] = Utility::readFile($dir."/username");
		$return["password"] = Utility::readFile($dir."/password");
		$return["displayName"] = Utility::readFile($dir."/displayName");
		
		$smtpConfig = new SmtpConfig();
		$smtpConfig->setInfo($return);
		
		return $smtpConfig;

	}
	
	public function findAll(){
		
		$return = array();
		$i = 0;
		$dir = $this->path;
		
		$dirs = Utility::listFiles($dir, 0);
		foreach($dirs as $folder){
			 $entity = $this->find($folder);
			 if (!is_null($entity)){
			 	$return[$i++] = $entity;
			 }
		}
		
		return $return;
		
	}
}

?>