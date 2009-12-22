<?php

require_once("interface.AbstractPersistence.php");
require_once("class.User.php");
require_once("class.Utility.php");

class UserPersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("user");
	}

	public function create($entity){
		
		$tid = $entity->getTid();
		$dir = $this->path."/".$tid;
		
		if (is_dir($dir)) return false;
		
		mkdir($dir);
		
		Utility::writeFile($dir."/password.txt", md5($entity->getPassword()));
		
		return true;
	}
	
	public function update($entity){}

	public function delete($tid){
		Utility::deleteDir($this->path.$tid);
	}

	public function find($tid){
		$dir = $this->path."/".$tid;
		
		$passwordfile = $dir."/password.txt";
		
		$info = array("tid"=>$tid);
		if (!is_dir($dir)) return null;
		
		if (!file_exists($passwordfile)){
			return null;
		}
		
		$info["password"] = Utility::readFile($passwordfile);
		
		$entity = new User();
		$entity->setInfo($info);
		
		return $entity;

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