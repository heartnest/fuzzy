<?php

// This script reads road names from json file
//

session_start();

$arr = array();
$filename = "../json/Bo_php.json";
$paris_filename = "../json/Paris_php.json";

$input = $_GET['query'];
$words = json_decode(file_get_contents($filename), true);
$paris_words = json_decode(file_get_contents($paris_filename), true);

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

#=============================================== begin
$time_start = microtime(true);

$shortest = -1;
$count = 0;
$city = "bologna"; // default city is Bologna

//search bologna
foreach ($words as $word) {
    //$lev = levenshtein($input, $word,1,10,10);
    $lev = accuratelev($input, $word);
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
    $count++;
}

//search paris
foreach ($paris_words as $pword) {
    $lev = accuratelev($input, $pword);
    if ($lev == 0) {
        $closest = $pword;
        $shortest = 0;
        $city = "paris";
        break;
    }
    if ($lev < $shortest || $shortest < 0) {
        $closest  = $pword;
        $shortest = $lev;
        $city = "paris";
    }
    $count++;
}


$formattedaddress= $pnum." ".$closest;

$time_end = microtime(true);
$time = round(($time_end - $time_start)*1000,2);
#=============================================== end

//$geo = geocode($closest,$pnum);
$geo = geocodeByCity($closest,$pnum,$city);

$arr['time'] = $time;
$arr['addr'] = $closest;
$arr['dist'] = $shortest." cnt:".$count;
$arr['geocode'] = $geo;
//$arr['addrurl'] = getUrlFromAddr($closest,$pnum);
$arr['addrurl'] = $_SESSION['addrurl'];


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
        if (trim($sa) != "") {
            $tmplev = -1;

            foreach($splittedb as $sb)
            {
                //1 insertion 10 substition 10 deletion
                $localev = levenshtein($sa,$sb,1,10,10);
                if ($localev < $tmplev || $tmplev<0) {
                    $tmplev = $localev;
                }
            }

            $totaldistance += $tmplev;
        }
        
    }
    return $totaldistance;
}

function geocodeByCity($street,$num,$city){
    $url = getUrlFromAddrAndCity($street,$num,$city);
    $json = json_decode(file_get_contents($url), true);

    if ($json[0]["lat"] == null) {
       $url = getUrlFromAddrAndCity2($street,$num,$city);
       $json = json_decode(file_get_contents($url), true);
    }

    $_SESSION['addrurl'] = $url; 
    return $json[0]["lat"].",".$json[0]["lon"];
}

function getUrlFromAddrAndCity($street,$num,$city){
    $addr = $num." ".$street;
    //$url = "http://nominatim.openstreetmap.org/search/".rawurlencode($addr).",%20bologna?format=json";
    $url = "http://nominatim.openstreetmap.org/search/$city/".rawurlencode($street)."/".$num."?format=json";
    return $url;
}

function getUrlFromAddrAndCity2($street,$num,$city){

    $splitted = split(" ",$street);

    $street = "";
    for ($i=0; $i < count($splitted) -1 ; $i++) { 
        if ( $i == count($splitted) -2) {
            $street .= $splitted[$i+1]." ".$splitted[$i];
            break;
        }else
        $street .= $splitted[$i]." ";
    }
    $street = trim($street);

    $url = "http://nominatim.openstreetmap.org/search/$city/".rawurlencode($street)."/".$num."?format=json";
    return $url;
}


function geocode($street,$num){
    $url = getUrlFromAddr($street,$num);
    $json = json_decode(file_get_contents($url), true);

    return $json[0]["lat"].",".$json[0]["lon"];
}

function getUrlFromAddr($street,$num){
    $addr = $num." ".$street;
    //$url = "http://nominatim.openstreetmap.org/search/".rawurlencode($addr).",%20bologna?format=json";
    $url = "http://nominatim.openstreetmap.org/search/bologna/".rawurlencode($street)."/".$num."?format=json";
    return $url;
}


?>