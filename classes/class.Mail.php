<?php

require_once("class.Entity.php");

class Mail extends Entity{
	
	public function getSubject(){
		return $this->info["subject"];
	}
	
	public function setSubject($subject){
		$this->info["subject"] = $subject;
	}
	
	public function getContent(){
		return $this->info["content"];
	}
	 
	public function setContent($content){
		$this->info["content"] = $content;
	}
	
	public function getFilelist(){
		return $this->info["filelist"];
	}
	
	public function setFilelist($filelist){
		$this->info["filelist"] = $filelist;
	}
	
	public function getImagelist(){
		return $this->info["imagelist"];
	}
	
	public function setImagelist($imagelist){
		$this->info["imagelist"] = $imagelist;
	}
	
	public function exportXML(){
		$document = new DomDocument("1.0", "utf-8");
		$root = $document->createElement("mailinfo");
		
		$subject = $document->createElement("subject");
		$subject->appendChild($document->createTextNode($this->getSubject()));
		$root->appendChild($subject);
		
		$content = $document->createElement("content");
		$content->appendChild($document->createTextNode($this->getContent()));
		$root->appendChild($content);
		
		$filelist = $this->getFilelist();
		foreach($filelist as $file){
			$node = $document->createElement("file");
			$node->appendChild($document->createTextNode($file));
			$root->appendChild($node);
		}
		
		$imagelist = $this->getImagelist();
		foreach($imagelist as $image){
			$node = $document->createElement("image");
			$node->appendChild($document->createTextNode($image));
			$root->appendChild($node);
		}
		
		$document->appendChild($root);
		
		$xml = $document->saveXML();		
		
		return str_ireplace(
			'<?xml version="1.0" encoding="utf-8"?>', 
			'<?xml version="1.0" encoding="gb2312"?>', 
			$xml);
	}
	
	public function buildLiCode(){
		$return = "<li>";
		$return .= ("<a target='_blank' href='viewlocal.php?tid=".$this->getTid()."'>".$this->getSubject()."</a> ");
		$return .= ("<a href='compose.php?action=modify&tid=".$this->getTid()."'>±à¼­</a> ");
		$return .= ("<a href='presend.php?redirect=dosend.php&tid=".$this->getTid()."'>·¢ËÍ</a> ");
		$return .= "</li>";
		return $return;
	}
	
	public function buildTrCode(){
		$tid = $this->getTid();
		$subject = $this->getSubject();
		$return = "<tr>";
		$return .= ("<td><a target='_blank' href='viewlocal.php?mode=mail&tid=".$tid."'>".$subject."</a></td>");
		$return .= ("<td><a href='compose.php?action=modify&tid=".$tid."'>±à¼­</a></td>");
		$return .= ("<td><a href='presend.php?redirect=dosend.php&tid=".$tid."'>·¢ËÍ</a></td>");
		$return .= ("<td><a href='deletedir.php?redirect=index.php&dir=".urlencode('upload/'.$tid)."'>É¾³ı</a></td>");
		$return .= "</tr>";
		return $return;
	}
	
}

?>