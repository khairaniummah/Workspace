<?php 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);
ini_set('auto_detect_line_endings', true);
require_once('./Converter.php');
$proc = new XsltProcessor;

$t = new Converter;
if ($_GET["search"] == 'dataxml'){ //perintah: http://localhost/main.php?search=dataxml
	$inputFile = 'Menu.xml';
	$doc = new DOMDocument();
	$doc->load('Menu.xsl');
	$proc->importStylesheet($doc);
	//$xml = file_get_contents($inputFile);
	$doc2 = new DOMDocument();
	$doc2->load($inputFile);
	echo $proc->transformToXML($doc2);
	//$xml = file_get_contents($inputFile);

}
else if ($_GET["search"] == 'datacsv'){ //perintah: http://localhost/main.php?search=datacsv
	$convert = $t->csvConverter();
	$inputFile = 'output.xml';
	//$xml = file_get_contents($inputFile);
	//echo $xml;
	$doc = new DOMDocument();
	$doc->load('output.xsl');
	$proc->importStylesheet($doc);
	//$xml = file_get_contents($inputFile);
	$doc2 = new DOMDocument();
	$doc2->load($inputFile);
	echo $proc->transformToXML($doc2);
}

else if ($_GET["search"] == 'datasql'){ //perintah: http://localhost/main.php?search=datasql
	$convert = $t->sqlConverter();
	$doc = new DOMDocument();
	$doc->load('datasql.xsl');
	$proc->importStylesheet($doc);
	$inputFile = 'datasql.xml';
	//$xml = file_get_contents($inputFile);
	$doc2 = new DOMDocument();
	$doc2->load($inputFile);
	echo $proc->transformToXML($doc2);
}
?>
