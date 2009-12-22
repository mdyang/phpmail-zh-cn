<?php

require_once("class.Entity.php");

class CardTemplate extends Entity{
	
	public function getName(){
		return $this->info["name"];
	}
	
	public function setName($name){
		$this->info["name"] = $name;
	}
	
	public function buildLiCode(){
		$return = "<li>";
		$return .= $this->getName();
		$return .= "</li>";
		return $return;
	}

	public function buildTrCode(){
		$tid = $this->getTid();
		$name = $this->getName();
		$return = "<tr>";
		$return .= ("<td><a target='_blank' href='viewlocal.php?mode=cardtmpl&tid=".$tid."'>".$name."</a></td>");
		$return .= ("<td><a href='deletedir.php?redirect=managecardtmpl.php&dir=".urlencode('cardtmpl/'.$tid)."'>É¾³ý</a></td>");
		$return .= "</tr>";
		return $return;
	}
}

?>