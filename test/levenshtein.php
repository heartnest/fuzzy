<?php

// This script reads road names from json file
//


$filename = "Bo_php.json";
$input = $_GET['query'];
$words = json_decode(file_get_contents($filename), true);



#===============================================
$time_start = microtime(true);


$shortest = -1;

// loop through words to find the closest
foreach ($words as $word) {
    $lev = levenshtein($input, $word);
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


#===============================================
$time_start2 = microtime(true);


$shortest2 = -1;

// loop through words to find the closest
foreach ($words as $word2) {
    $lev2 = lev2($input, $word2);
    if ($lev2 == 0) {
        $closest2 = $word2;
        $shortest2 = 0;
        break;
    }
    if ($lev2 < $shortest2 || $shortest2 < 0) {
        $closest2  = $word2;
        $shortest2 = $lev2;
    }
}

$time_end2 = microtime(true);
$time2 = round(($time_end2 - $time_start2)*1000,2);

#===============================================
$time_start3 = microtime(true);


$shortest3 = -1;

// loop through words to find the closest
foreach ($words as $word3) {
    $lev3 = lev3($input, $word3);
    if ($lev3 == 0) {
        $closest3 = $word3;
        $shortest3 = 0;
        break;
    }
    if ($lev3 < $shortest3 || $shortest3 < 0) {
        $closest3  = $word3;
        $shortest3 = $lev3;
    }
}

$time_end3 = microtime(true);
$time3 = round(($time_end3 - $time_start3)*1000,2);

#===============================================
$time_start4 = microtime(true);


$shortest4 = -1;

// loop through words to find the closest
foreach ($words as $word4) {
  //in rep del
    $lev4 = levenshtein($input, $word4,1,10,10);
    if ($lev4 == 0) {
        $closest4 = $word4;
        $shortest4 = 0;
        break;
    }
    if ($lev4 < $shortest4 || $shortest4 < 0) {
        $closest4  = $word4;
        $shortest4 = $lev4;
    }
}

$time_end4 = microtime(true);
$time4 = round(($time_end4 - $time_start4)*1000,2);




echo "algo core: $input <span class='glyphicon glyphicon-arrow-right'></span> $closest (Dist: $shortest Time:$time ms)<br/>";
echo "algo impl: $input <span class='glyphicon glyphicon-arrow-right'></span> $closest2 (Dist: $shortest2 Time:$time2 ms)<br/>";
echo "algo impl: $input <span class='glyphicon glyphicon-arrow-right'></span> $closest3 (Dist: $shortest3 Time:$time3 ms)<br/>";
echo "algo weig: $input <span class='glyphicon glyphicon-arrow-right'></span> $closest4 (Dist: $shortest4 Time:$time4 ms)";







function lev2($s,$t) {
	$m = strlen($s);
	$n = strlen($t);
 
	for($i=0;$i<=$m;$i++) $d[$i][0] = $i;
	for($j=0;$j<=$n;$j++) $d[0][$j] = $j;
 
	for($i=1;$i<=$m;$i++) {
		for($j=1;$j<=$n;$j++) {
			$c = ($s[$i-1] == $t[$j-1])?0:1;
			$d[$i][$j] = min($d[$i-1][$j]+1,$d[$i][$j-1]+1,$d[$i-1][$j-1]+$c);
		}
	}
 
	return $d[$m][$n];
}


function lev3($s1, $s2) {
  //       discuss at: http://phpjs.org/functions/levenshtein/
  //      original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
  //      bugfixed by: Onno Marsman
  //       revised by: Andrea Giammarchi (http://webreflection.blogspot.com)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  // reimplemented by: Alexander M Beedie
  //        example 1: levenshtein('Kevin van Zonneveld', 'Kevin van Sommeveld');
  //        returns 1: 3

  if ($s1 == $s2) {
    return 0;
  }

  $s1_len = strlen($s1);
  $s2_len = strlen($s2);
  if ($s1_len === 0) {
    return $s2_len;
  }
  if ($s2_len === 0) {
    return $s1_len;
  }


    $s1 = str_split($s1);
    $s2 = str_split($s2);
  

  // $v0 = new Array($s1_len + 1);
  // $v1 = new Array($s1_len + 1);

  $v0 = array_fill(0, $s1_len + 1, NULL);
  $v1 = array_fill(0, $s1_len + 1, NULL);

  $s1_idx = 0;
  $s2_idx = 0;
  $cost = 0;

  for ($s1_idx = 0; $s1_idx < $s1_len + 1; $s1_idx++) {
    $v0[$s1_idx] = $s1_idx;
  }
  $char_s1 = '';
  $char_s2 = '';
  for ($s2_idx = 1; $s2_idx <= $s2_len; $s2_idx++) {
    $v1[0] = $s2_idx;
    $char_s2 = $s2[$s2_idx - 1];

    for ($s1_idx = 0; $s1_idx < $s1_len; $s1_idx++) {
      $char_s1 = $s1[$s1_idx];
      $cost = ($char_s1 == $char_s2) ? 0 : 1;
      $m_min = $v0[$s1_idx + 1] + 1;
      $b = $v1[$s1_idx] + 1;
      $c = $v0[$s1_idx] + $cost;
      if ($b < $m_min) {
        $m_min = $b;
      }
      if ($c < $m_min) {
        $m_min = $c;
      }
      $v1[$s1_idx + 1] = $m_min;
    }
    $v_tmp = $v0;
    $v0 = $v1;
    $v1 = $v_tmp;
  }
  return $v0[$s1_len];
}

?>