<?php

class Entity{
	
	protected $info = array();
		
	public function getTid(){
		return $this->info["tid"];
	}
	
	public function setTid($tid){
		$this->info["tid"] = "".$tid;
	}
	
	public function setInfo($info){
		$this->info = $info;
	}
	
	public function getInfo(){
		return $this->info;
	}
	
	public function exportXML(){
		
	}
	
	public static function getField($entity, $field){
		if (!($entity instanceof Entity)) return null;
		if (is_null($entity)) return "";
		$map = $entity->getInfo();
		$value = $map[$field];
		if (is_null($value)) return "";
		return $value;
	}
	
}

?>