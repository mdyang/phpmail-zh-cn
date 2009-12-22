<?php

require_once("interface.AbstractPersistence.php");
require_once("class.AddressBook.php");
require_once("class.Utility.php");

class AddressBookPersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("addressbook");
	}
	
	public function create($entity){
		$tid = $entity->getTid();
		
		$dir = $this->path."/".$tid;
		
		if (!is_dir($dir)){
			mkdir($dir);
		}
		
		$namefile = $dir."/name.txt";
		$contfile = $dir."/main.txt";
		
		Utility::writeFile($namefile, $entity->getName());
		
		Utility::writeFile($contfile, $entity->getContent());
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
		$contfile = $dir."/main.txt";
		
		$info = array("tid"=>$tid);
		if (!is_dir($dir)) return null;
		
		if (!file_exists($namefile) || !file_exists($contfile)){
			return null;
		}
		
		// load subject
		$info["name"] = Utility::readFile($namefile);
		
		// load content
		$info["content"] = Utility::readFile($contfile);
		
		$entity = new AddressBook();
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