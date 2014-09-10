<?php

// This script reads road names from json file
//


$filename = "../json/file.json";
$json = json_decode(file_get_contents($filename), true);
echo " aaa $json";
foreach($json as $msg)
{
    echo $msg."<br />";
}

?>