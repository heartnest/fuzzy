<?php

// $arr = array("ac tv aa","aa za","aa ba");
// // $a = "via rondolf cavini";
// // $b = "viale ronmolf acivni";

// $a = "ABC";
// $b = "abc";

// $res = accuratelev(strtoupper($a),strtoupper($b));
// $res2 = levenshtein($a, $b);
// echo "accuratelev: ".$res." lev:".$res2;

// $url = "http://nominatim.openstreetmap.org/search/33%20viale%20alfredo%20oriani,%20bologna?format=json&polygon=1&addressdetails=1";
// $url = "http://nominatim.openstreetmap.org/search/33%20viale%20oriani%20alfredo,%20bologna?format=json&polygon=1&addressdetails=1";
// $filename = "../json/Bo_php.json";
// $json = json_decode(file_get_contents($url), true);

// var_dump($json);
// echo $json[0]["lat"];

// $url = "http://nominatim.openstreetmap.org/search/33%20viale%20oriani%20alfredo,%20bologna?format=json&polygon=1&addressdetails=1";
// $json = json_decode(file_get_contents($url), true);

// return $json[0]["lat"].",".$json[0]["lon"];

// echo rawurlencode('viale oriani alfredo 33');

$str = "viale 12";

// $splitted = split(" ",$str);

// $street = "";
// for ($i=0; $i < count($splitted) -1 ; $i++) { 
// 	if ( $i == count($splitted) -2) {
// 		$street .= $splitted[$i+1]." ".$splitted[$i];
// 		break;
// 	}else
// 	$street .= $splitted[$i]." ";
// }
// $street = trim($street);
// echo "$street";

$x = getUrlFromAddrAndCity2("via gusto righi",3,'bo');
echo "$x";

// $pstr = "";
// $pnum = "";
// foreach ($splitted as $item) {
// 	if (is_numeric($item)) {
// 		$pnum = $item;
// 	}else{
// 		$pstr .= $item." ";
// 	}
// }
//echo trim($pnum." ".$pstr);


function getUrlFromAddrAndCity2($street,$num,$city){

    $splitted = split(" ",$street);
echo "aa ".count($splitted);
    $street = "";
    for ($i=0; $i < count($splitted) -1 ; $i++) { 
echo "$i aa ";
        if ( $i == count($splitted) -2) {
            $street .= $splitted[$i+1]." ".$splitted[$i];
            break;
        }else
        $street .= $splitted[$i]." ";

        echo "$street";
    }
    $street = trim($street);

    $url = "http://nominatim.openstreetmap.org/search/$city/".rawurlencode($street)."/".$num."?format=json";
    return $url;
}
//================== cal lev ==================

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
			$localev = levenshtein($sa, $sb);
			if ($localev < $tmplev || $tmplev<0) {
				$tmplev = $localev;
			}
		}

	    $totaldistance += $tmplev;
	}

	return $totaldistance;
}


?>

