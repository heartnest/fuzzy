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
    //$lev = levenshtein($input, $word,1,10,10);
    $lev = accuratelev($input, $word);
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

function accuratelev($a,$b){
    $a = strtoupper($a);
    $b = strtoupper($b);

    $splitteda = split(" ",$a);
    $splittedb = split(" ",$b);

    $totaldistance = 0;
    if (count($splitteda) == 0 || count($splittedb) == 0) {
        return levenshtein($a, $b);
    }

    foreach($splitteda as $sa)
    {
        $tmplev = -1;

        foreach($splittedb as $sb)
        {
            $localev = levenshtein($sa, $sb,10,10,10);
            if ($localev < $tmplev || $tmplev<0) {
                $tmplev = $localev;
            }
        }

        $totaldistance += $tmplev;
    }

    return $totaldistance;
}


?>