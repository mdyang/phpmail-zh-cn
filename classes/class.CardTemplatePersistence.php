<?php

require_once("interface.AbstractPersistence.php");
require_once("class.CardTemplate.php");
require_once("class.Utility.php");

class CardTemplatePersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("cardtmpl");
	}

	public function create($entity){
		
		$tid = $entity->getTid();
		$dir = $this->path."/".$tid;
		if (!is_dir($dir)){
			mkdir($dir);
		}
		
		Utility::writeFile($dir."/name.txt", $entity->getName());		
	}

	public function update($entity){
		$this->create($entity);
	}

	public function delete($tid){
		Utility::deleteDir($this->path.$tid);
	}

	public function find($tid){
		$dir = $this->path."/".$tid;
		$namefile = $dir."/name.txt";
		$info = array("tid"=>$tid);
		if (!is_dir($dir)) return null;
		
		if (!file_exists($namefile)){
			return null;
		}
		
		// load subject
		$info["name"] = Utility::readFile($namefile);
		
		$entity = new CardTemplate();
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