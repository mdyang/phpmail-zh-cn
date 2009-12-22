<?php

require_once("interface.AbstractPersistence.php");
require_once("class.Mail.php");
require_once("class.Utility.php");

class TemplatePersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("template");
	}
	
	public function create($entity){}

	public function update($entity){
		$tid = $entity->getTid();
		
		$dir = $this->path."/".$tid;
		$namefile = $dir."/name.txt";
		$contfile = $dir."/main.html";
		
		Utility::writeFile($namefile, $entity->getName());
		
		Utility::writeFile($contfile, $entity->getContent());
	}
	
	public function delete($tid){
		Utility::deleteDir($this->path.$tid);
	}

	public function find($tid){
		$dir = $this->path."/".$tid;
		$namefile = $dir."/name.txt";
		$contfile = $dir."/main.html";
		
		$info = array("tid"=>$tid);
		if (!is_dir($dir)) return null;
		
		if (!file_exists($namefile) || !file_exists($contfile)){
			return null;
		}
		
		// load subject
		$info["name"] = Utility::readFile($namefile);
		
		// load content
		$info["content"] = Utility::readFile($contfile);
		
		$entity = new Template();
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