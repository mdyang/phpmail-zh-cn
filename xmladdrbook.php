<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
header("Content-type: text/xml; charset=gb2312");

require_once("classes/class.AddressBookPersistence.php");
require_once("classes/class.AddressBook.php");

$action = $_GET["action"];

if ($action == "list"){
	$persistence = new AddressBookPersistence();
	$addrbooks = $persistence->findAll();
	
	$document = new DomDocument("1.0", "utf-8");
	$root = $document->createElement("addrbooks");
	
	foreach($addrbooks as $addrbook){
		$node = $document->createElement("template");
		
		$tid = $document->createAttribute("tid");
		$tid->appendChild($document->createTextNode($addrbook->getTid()));
		$node->appendChild($tid);
		
		$name = $document->createAttribute("name");
		$name->appendChild($document->createTextNode($addrbook->getName()));
		$node->appendChild($name);
		
		$root->appendChild($node);
	}
	
	$document->appendChild($root);
	
	$xml = $document->saveXML();
	
	echo str_ireplace(
				'<?xml version="1.0" encoding="utf-8"?>', 
				'<?xml version="1.0" encoding="gb2312"?>', 
	$xml);
}
if ($action == "content"){
	$tid = $_GET["tid"];
	$persistence = new AddressBookPersistence();
	$addrbook = $persistence->find($tid);
	
	$document = new DomDocument("1.0", "utf-8");
	$root = $document->createElement("content");
	
	$root->appendChild($document->createTextNode($addrbook->getContent()));
	
	$document->appendChild($root);
	
	$xml = $document->saveXML();
	
	echo str_ireplace(
				'<?xml version="1.0" encoding="utf-8"?>', 
				'<?xml version="1.0" encoding="gb2312"?>', 
	$xml);
}
?>