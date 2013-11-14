<?php 
require_once('./Converter.php');
$proc = new XsltProcessor;

$t = new Converter;
if ($_GET["search"] == 'dataxml'){ //perintah: http://localhost/get.php?search=dataxml
	$inputFile = 'Menu.xml';
	$xml = file_get_contents($inputFile);
	print $xml;
	
}
else if ($_GET["search"] == 'datacsv'){ //perintah: http://localhost/get.php?search=datacsv
	$convert = $t->csvConverter();
	$inputFile = 'output.xml';
	$xml = file_get_contents($inputFile);
	echo $xml;
}

else if ($_GET["search"] == 'datasql'){ //perintah: http://localhost/get.php?search=datasql
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
