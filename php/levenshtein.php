<?php

// This script reads road names from json file
//

$arr = array();
$filename = "../json/Bo_php.json";
$input = $_GET['query'];
$words = json_decode(file_get_contents($filename), true);

$splitted = split(" ",$input);

$pstr = "";
$pnum = "";

foreach ($splitted as $item) {
    if (is_numeric($item)) {
        $pnum = $item;
    }else{
        $pstr .= $item." ";
    }
}

$input = trim($pstr);

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

$formattedaddress= $pnum." ".$closest ;

$time_end = microtime(true);
$time = round(($time_end - $time_start)*1000,2);

$geo = geocode($formattedaddress);

$arr['time'] = $time;
$arr['addr'] = $closest;
$arr['dist'] = $shortest;
$arr['geocode'] = $geo;
$arr['addrurl'] = getUrlFromAddr($formattedaddress);


//echo "$input <span class='glyphicon glyphicon-arrow-right'></span> $closest (Dist: $shortest Time:$time ms)<br/>";
echo json_encode($arr);


// -------------------- functions -------------------- //

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
            $localev = levenshtein($sa,$sb,1,10,10);
            if ($localev < $tmplev || $tmplev<0) {
                $tmplev = $localev;
            }
        }

        $totaldistance += $tmplev;
    }
    return $totaldistance;
}

function geocode($addr){
   // $url = "http://nominatim.openstreetmap.org/search/33%20viale%20oriani%20alfredo,%20bologna?format=json&polygon=1&addressdetails=1";
//    $url = "http://nominatim.openstreetmap.org/search/".rawurlencode($addr).",%20bologna?format=json&polygon=1&addressdetails=1";
    $url = getUrlFromAddr($addr);
    $json = json_decode(file_get_contents($url), true);

    return $json[0]["lat"].",".$json[0]["lon"];
}

function getUrlFromAddr($addr){
    $url = "http://nominatim.openstreetmap.org/search/".rawurlencode($addr).",%20bologna?format=json&polygon=1&addressdetails=1";
    return $url;
}


?>