<?php
header("content-type:text/plain");
function isPrime($num) {
	if($num<=0 || !is_int($num)){
		return false;
	}

    if($num == 2)
        return true;
		
    if($num % 2 == 0) {
        return false;
    }
    for($i = 3; $i <= ceil(sqrt($num)); $i = $i + 2) {
        if($num % $i == 0)
            return false;
    }

    return true;
}

function allEqs($e){
	$algo[0] = "(2 {$e[0]} 3) {$e[1]} 5 {$e[2]} 7";
	$algo[1] = "2 {$e[0]} (3 {$e[1]} 5) {$e[2]} 7";
	$algo[2] = "2 {$e[0]} 3 {$e[1]} (5 {$e[2]} 7)";
	$algo[3] = "(2 {$e[0]} 3 {$e[1]} 5) {$e[2]} 7";
	$algo[4] = "2 {$e[0]} (3 {$e[1]} 5 {$e[2]} 7)";
	$algo[5] = "2 {$e[0]} 3 {$e[1]} 5 {$e[2]} 7";
	return $algo;
	//eval($algo);
	
	//return $answer;
}

function AllPermutations($InArray, $InProcessedArray = array())
{
    $ReturnArray = array();
    foreach($InArray as $Key=>$value)
    {
        $CopyArray = $InProcessedArray;
        $CopyArray[$Key] = $value;
        $TempArray = array_diff_key($InArray, $CopyArray);
        if (count($TempArray) == 0)
        {
            $ReturnArray[] = $CopyArray;
        }
        else
        {
            $ReturnArray = array_merge($ReturnArray, AllPermutations($TempArray, $CopyArray));
        }
    }
    return $ReturnArray;
}

$ele = array("+","-","*","/");
$power_set = AllPermutations($ele);
foreach($power_set as $set){
	
 $accept[] = array_slice($set, 0, 3); ;
 
}
array_unique($accept);
//print_r($accept);

foreach($accept as $algo){
	$eqs = allEqs($algo);
	foreach($eqs as $eq){
		$base[] = $eq;
	}
}
foreach($base as $v){
	

	eval("\$answer = $v ;");	
	if(isPrime($answer)){	
	echo $v;
	echo " = ";
	echo $answer;
	
	echo "\n";
	}
}