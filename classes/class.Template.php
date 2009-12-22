<?php

require_once("class.Entity.php");

class Template extends Entity{
	
	public function getName(){
		return $this->info["name"];
	}
	
	public function setName($name){
		$this->info["name"] = $name;
	}
	
	public function getContent(){
		return $this->info["content"];
	}
	 
	public function setContent($content){
		$this->info["content"] = $content;
	}

	public function buildTrCode(){
		$tid = $this->getTid();
		$name = $this->getName();
		$return = "<tr>";
		$return .= ("<td><a target='_blank' href='viewlocal.php?mode=template&tid=".$tid."'>".$name."</a></td>");
		$return .= ("<td><a href='deletedir.php?redirect=managetmpl.php&dir=".urlencode('template/'.$tid)."'>É¾³ı</a></td>");
		$return .= "</tr>";
		return $return;
	}
}

?>