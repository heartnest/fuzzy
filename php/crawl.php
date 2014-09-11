<?php

#This file crawls normal web page to extract Bologna street names which are disordered, like, "zamboni via"

//variables
$filename = "../json/Bo_php.json";
$arr = array();

//crawling
$dom = new DOMDocument();
$dom ->loadHTMLFile('http://localhost/fuzzy/bologna.php');
$xpath = new DOMXPath($dom);
$param = $xpath->query("//div[@class='alfa_info']/p");
if($param->length >=1){ 
	foreach($param as $p)
	{
		$res = "";
		$raw = $p->textContent;
		$splitted = split(' ',$raw);

		for ($i = 0; $i < count($splitted); $i++) {
			if (strtoupper($splitted[$i]) == "VIA" || strtoupper($splitted[$i]) == "PIAZZA" || strtoupper($splitted[$i]) == "VIALE" || strtoupper($splitted[$i]) == "VICOLO" || strtoupper($splitted[$i]) == "PIAZZALE" || strtoupper($splitted[$i]) == "SALITA" || strtoupper($splitted[$i]) == "PIAZZETTA" || strtoupper($splitted[$i]) == "LUNGOTEVERE"  || strtoupper($splitted[$i]) == "LARGO" || strtoupper($splitted[$i]) == "PONTE" || strtoupper($splitted[$i]) == "ARCO" || strtoupper($splitted[$i]) == "ROTONDA" ) {
				$q = "";
				for ($j = $i; $j < count($splitted); $j++) {
					$q .= $splitted[$j]." ";
				}
				$res = $q.$res;
				break;
			}else
			$res .= $splitted[$i]." ";
		};

		$res = trim($res);

		if (!in_array($res, $arr)) {
			$arr[] = $res;
		}

	}
}

// foreach($arr as $a)
// 	{
// 		echo $a."<br/>";
// 	}

 $handle = fopen($filename, "w");

 $fwrite = fwrite($handle, json_encode($arr));
 if (!$fwrite) {
 	echo "File $filename NON è stato creato! numero di strade totale:".count($arr);
 }else {
 	echo "File $filename con successo".count($arr);
 }
?>