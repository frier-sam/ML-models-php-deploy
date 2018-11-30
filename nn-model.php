<?php

function get_layers($config,$nl){
	$nnarc = array();
	$array = array_values($config['config']);
	$inp = $array[0]['config']["batch_input_shape"][1];
	$flow = array();
	$bias = array();
	array_push($flow,$inp);
	for($i=0;$i<$nl;$i++){
		
		$units =  $array[$i]['config']['units'];
		$act =  $array[$i]['config']['activation'];
		$ubias =  $array[$i]['config']['use_bias'];
		####$act =  $array[i]['config']['activation'];
		array_push($flow,$units);
		array_push($bias,$ubias);
		$nnarc[$i] = array($units,$act,$ubias);
	}
	return array($nnarc,$inp,$flow,$bias);
}

function dim_check($arr,$ch){
	if((count($arr[0]) == $ch[0]) && (count($arr[0][0])==$ch[1])){
		return True;
	}
	else{
		return False;
	}
	return;
}
function check_weights($weights,$flow,$bias){
	$i =0;
	$k = 0;
	while($i < count($flow)){
		
		
		if(dim_check($weights['data'][$i],array($flow[$k],$flow[$k+1]))){
			$k++;
		}
		else{
			return False;
		}
		if($bias[$k]){
			$i++;
			if(count($weights['data'][$i][0])==$flow[$k]){
				#echo "done";
			}
			else{
				return False;
			}
		}
		
		
		$i++;
	
	}
	return True;
}

#echo getcwd();
$config = file_get_contents("config.json");
$array = json_decode($config, true);
$nlayer = count($array['config']) ;	
$arc = get_layers($array,$nlayer);
$inp = $arc[1];
$hidn = $arc[0];
$flow = $arc[2];
$bias = $arc[3];
$wei = file_get_contents("weights.json");
$weights = json_decode($wei, true);
if(check_weights($weights,$flow,$bias)){
	echo "Model Loaded";
	
}

#echo count($weights['data'][0][0][0]);

#var_dump($arwts);
#echo $hidn;


?>