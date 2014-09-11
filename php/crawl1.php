<?php

#This file crawls wikipedia page to extract Paris street names.

//variables
$filename = "../json/Paris_php.json";
$arr = array();

//crawling
$dom = new DOMDocument();
$dom ->loadHTMLFile('http://en.wikipedia.org/wiki/User:ThePromenader/Paris_street_list');
$xpath = new DOMXPath($dom);
$param = $xpath->query("//a[@class='new']");
if($param->length >=1){ 
	foreach($param as $p)
	{
		$arr[] = $p->textContent;
	}
}

 $handle = fopen($filename, "w");

 $fwrite = fwrite($handle, json_encode($arr));
 if (!$fwrite) {
 	echo "File NON è stato creato! numero di strade totale:".$param->length;
 }else {
 	echo "File con successo";
 }
?>