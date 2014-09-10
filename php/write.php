<?php
#This file writes road names to json files

$filename = "../json/file.json";
$arr = array();

$messages = $_POST['p'];
foreach($messages as $msg)
{
    $arr[] = $msg;
}



//$arr = array("ven" => "la", "sab" => "lo");

$handle = fopen($filename, "r+");

$fwrite = fwrite($handle, json_encode($arr));

//$fwrite = fwrite($handle, json_encode($arr,JSON_UNESCAPED_UNICODE));


//echo json_encode($arr);
echo "OK";

?>