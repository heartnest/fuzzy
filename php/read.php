<?php

// This script reads road names from json file
//


$filename = "../json/Bo_php.json";
$json = json_decode(file_get_contents($filename), true);

foreach($json as $msg)
{
	if (count(split(' ',$msg))>3) {
		# code...
		echo $msg."<br />";
	}
    
}

?>