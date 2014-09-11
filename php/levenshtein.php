<?php

// This script reads road names from json file
//


$filename = "../json/Bo_php.json";
$input = $_GET['query'];
$words = json_decode(file_get_contents($filename), true);


#===============================================
$time_start = microtime(true);

$shortest = -1;

// loop through words to find the closest
foreach ($words as $word) {
    $lev = levenshtein($input, $word,1,10,10);
    //similar_text($input, $word, $lev); 
    if ($lev == 0) {

        // closest word is this one (exact match)
        $closest = $word;
        $shortest = 0;
        break;
    }
    if ($lev < $shortest || $shortest < 0) {
        $closest  = $word;
        $shortest = $lev;
    }
}

$time_end = microtime(true);
$time = round(($time_end - $time_start)*1000,2);



echo "$input <span class='glyphicon glyphicon-arrow-right'></span> $closest (Dist: $shortest Time:$time ms)<br/>";



?>