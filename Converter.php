<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);
ini_set('auto_detect_line_endings', true);
class Converter{
	function csvConverter(){
		$inputFile   = 'coba.csv';
		$outputFile   = 'output.xml';

		// Membuka file csv yang akan dibaca
		$input  = fopen($inputFile, 'r');

		$headers = fgetcsv($input);

		$doc = new DomDocument();
		$doc->formatOutput = true;
		$root = $doc->createElement('rows');
		$root = $doc->appendChild($root);

		// Melakukan looping sampai baris terakhir
		while (($row = fgetcsv($input)) !== FALSE){
			$temp = $doc->createElement('row');
			foreach ($headers as $i => $header){
				$child = $doc->createElement($header);
				$child = $temp->appendChild($child);
				$value = $doc->createTextNode($row[$i]);
				$value = $child->appendChild($value);
			}
			$root->appendChild($temp);
		}
		//menambahkan tag xml stylesheet pada file output.xml
		$insertBefore = $doc->firstChild;
		foreach($doc->childNodes as $node)
		{
			if ($node->nodeType == XML_ELEMENT_NODE)
			{
				$insertBefore = $node;
				break;
			}
		}
		$pi = $doc->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="output.xsl"');
		$doc->insertBefore($pi, $insertBefore);
		
		$strxml = $doc->saveXML();
		$handle = fopen($outputFile, "w");
		fwrite($handle, $strxml);
		fclose($handle);
	}

	function sqlConverter(){
	// File SQL yang ada dimasukkan ke dalam database pada MySQL terlebih dahulu
	// baru setelah itu diconvert menjadi format XML dari database tersebut
	// Setting dengan MySQL
		$host       = "localhost";
		$user       = "root";
		$pass       = "";
		$database   = "pegawai";
		$outputFile = "datasql.xml";
	 
		// Query database
		$SQL_query = "SELECT * FROM PEGAWAI";
	 
		// connect dengan MySQL, memilih database, dan menyimpan hasil query database 
		$DB_link = mysql_connect($host, $user, $pass) or die("Could not connect to host.");
		mysql_select_db($database, $DB_link) or die ("Could not find or access the database.");
		$result = mysql_query ($SQL_query, $DB_link) or die ("Data not found. Your SQL query didn't work... ");

		// membuat XML
		//header("Content-type: application/xml");
		$XML = "<?xml version=\"1.0\"?>\n";
		$XML .= "<?xml-stylesheet type=\"text/xsl\" href=\"datasql.xsl\"?>\n";
		$XML .= "<database>\n";
	
		// rows
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {    
			$XML .= "\t<row>\n"; 
			$i = 0;
			// cells
			foreach ($row as $cell) {
				// mengganti karakter 
				$cell = str_replace("&", "&amp;", $cell);
				$cell = str_replace("<", "&lt;", $cell);
				$cell = str_replace(">", "&gt;", $cell);
				$cell = str_replace("\"", "&quot;", $cell);
				$col_name = mysql_field_name($result,$i);
				// menambahkan tag <identifier> </identifier> dari nama kolom
				$XML .= "\t\t<" . $col_name . ">" . $cell . "</" . $col_name . ">\n";
				$i++;
			}
			$XML .= "\t</row>\n"; 
		}
		$XML .= "</database>\n";
		//save ke file output
		$handle = fopen($outputFile, "w");
		fwrite($handle, $XML);
		fclose($handle);
	}
}
?>

