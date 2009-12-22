<?php

require_once("class.Entity.php");

class SmtpConfig extends Entity{
	
	public function getHost(){
		return $this->info["host"];
	}
	
	public function setHost($host){
		$this->info["host"] = $host;
	}
	
	public function getPort(){
		return $this->info["port"];
	}
	
	public function setPort($port){
		$this->info["port"] = $port;
	}
	
	public function getUsername(){
		return $this->info["username"];
	}
	
	public function setUsername($username){
		$this->info["username"] = $username;
	}
	
	public function getPassword(){
		return $this->info["password"];
	}
	
	public function setPassword($password){
		$this->info["password"] = $password;
	}
	
	public function getEmail(){
		return $this->info["email"];
	}
	
	public function setEmail($email){
		$this->info["email"] = $email;
	}
	
	public function getDisplayName(){
		return $this->info["displayName"];
	}
	
	public function setDisplayName($displayName){
		$this->info["displayName"] = $displayName;
	}
	
	public function buildLiCode(){
		$return = "<li>"; 
		$return .= ("<a href='editsmtp.php?action=modify&tid=".$this->getTid()."'>".$this->getEmail()."</a>");
		$return .= "</li>";
		return $return;
	}
	
	public function buildTrCode(){
		$tid = $this->getTid();
		$email = $this->getEmail();
		$host = $this->getHost();
		$port = $this->getPort();
		
		$return = "<tr>"; 
		$return .= ("<td>".$this->getDisplayName()."&lt;".$email."&gt; ·şÎñÆ÷: ".$host.":".$port."</td>");
		$return .= ("<td><a target='_blank' href='editsmtp.php?action=modify&tid=".$tid."'>ĞŞ¸Ä</a></td>");
		$return .= ("<td><a href='deletedir.php?redirect=managesmtp.php&dir=".urlencode('smtp/'.$tid)."'>É¾³ı</a></td>");
		$return .= "</tr>";
		return $return;
	}
	
	public function exportXML(){
		$document = new DomDocument("1.0", "gb2312");
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
		
		return $document;
	}
	
}

?>