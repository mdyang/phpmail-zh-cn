<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<?php
header("Content-type: text/xml; charset=gb2312");

require_once("classes/class.TemplatePersistence.php");
require_once("classes/class.Template.php");

$action = $_GET["action"];

if ($action == "list"){
	$persistence = new TemplatePersistence();
	$templates = $persistence->findAll();
	
	$document = new DomDocument("1.0", "utf-8");
	$root = $document->createElement("templates");
	
	foreach($templates as $template){
		$node = $document->createElement("template");
		
		$tid = $document->createAttribute("tid");
		$tid->appendChild($document->createTextNode($template->getTid()));
		$node->appendChild($tid);
		
		$name = $document->createAttribute("name");
		$name->appendChild($document->createTextNode($template->getName()));
		$node->appendChild($name);
		
		$image = $document->createAttribute("image");
		$image->appendChild($document->createTextNode("template/".$template->getTid()."/_files/_thumb.jpg"));
		$node->appendChild($image);
		
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
	$persistence = new TemplatePersistence();
	$template = $persistence->find($tid);
	
	$document = new DomDocument("1.0", "utf-8");
	$root = $document->createElement("content");
	
	$root->appendChild($document->createTextNode($template->getContent()));
	
	$document->appendChild($root);
	
	$xml = $document->saveXML();
	
	echo str_ireplace(
				'<?xml version="1.0" encoding="utf-8"?>', 
				'<?xml version="1.0" encoding="gb2312"?>', 
	$xml);
}
?>