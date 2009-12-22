<?php

require_once("class.Entity.php");

class Admin extends Entity{
	
	public function getPassword(){
		return $this->info["password"];
	}
	 
	public function setPassword($password){
		$this->info["password"] = $password;
	}
	
	public function buildTrCode(){
		$tid = $this->getTid();
		$password = $this->getPassword();
		$return = "<tr>";
		$return .= ("<td>".$tid."/".$password."</td>");
		$return .= ("<td><a href='deletedir.php?redirect=manageadmin.php&dir=".urlencode('admin/'.$tid)."'>É¾³ı</a></td>");
		$return .= "</tr>";
		return $return;
	}
	
}

?>