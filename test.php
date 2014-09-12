<?php

$arr = array("ac tv aa","aa za","aa ba");
// $a = "via rondolf cavini";
// $b = "viale ronmolf acivni";

$a = "ABC";
$b = "abc";

$res = accuratelev(strtoupper($a),strtoupper($b));
$res2 = levenshtein($a, $b);
echo "accuratelev: ".$res." lev:".$res2;

//================== cal lev ==================

function accuratelev($a,$b){

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

