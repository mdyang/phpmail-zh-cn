<?php

require_once("class.Entity.php");

class User extends Entity{
	
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
		$return .= ("<td><a href='deletedir.php?redirect=manageuser.php&dir=".urlencode('user/'.$tid)."'>É¾³ı</a></td>");
		$return .= "</tr>";
		return $return;
	}
	
}

?>