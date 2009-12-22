<?php

require_once("interface.AbstractPersistence.php");
require_once("class.Mail.php");
require_once("class.Utility.php");

class MailPersistence implements AbstractPersistence{
	
	private $path;
	
	public function __construct(){
		$this->path = Utility::getAbsolutePathRel("upload");
	}

	public function create($entity){
		
		$tid = $entity->getTid();
		$dir = $this->path."/".$tid;
		mkdir($dir);
		mkdir($dir."/attachments");
		mkdir($dir."/images");
		
		$content = $entity->getContent();
		
		Utility::writeFile($dir."/subject.txt", $entity->getSubject());
		Utility::writeFile($dir."/main.html", $content);
		
	}

	public function update($entity){
		$this->create($entity);
	}

	public function delete($tid){
		Utility::deleteDir($this->path.$tid);
	}

	public function find($tid){
		$dir = $this->path."/".$tid;
		$subfile = $dir."/subject.txt";
		$contfile = $dir."/main.html";
		$filesdir = $dir."/attachments";
		$imagesdir = $dir."/images";
		$info = array("tid"=>$tid);
		if (!is_dir($dir)) return null;
		
		if (!file_exists($subfile) || !file_exists($contfile)){
			return null;
		}
		
		// load subject
		$info["subject"] = Utility::readFile($subfile);
		
		// load content
		$info["content"] = Utility::readFile($contfile);
		
		$info["filelist"] = Utility::listFiles($filesdir);
		
		$info["imagelist"] = Utility::listFiles($imagesdir);
		
		$mail = new Mail();
		$mail->setInfo($info);
		
		return $mail;

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