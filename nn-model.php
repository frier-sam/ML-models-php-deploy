<?php

	class acti {
      function relu($arr){
			$res =[];
			for($i=0;$i<count($arr);$i++){
				if($arr[$i]<=0){
					array_push($res,0);
				}
				else{
					array_push($res,$arr[$i]);
					
				}
			}	
			return $res;
		}
      
	  function linear($arr){
			return $arr;	  
		} 
      
   }

   
class model {

	
	var $arc,$inp,$hidn ,$flow,$bias,$weights,$nlayer,$acti ;
	 
	function add($a,$b){
		$c = array_map(function (...$arrays) {
		return array_sum($arrays);
		}, $a, $b);
		return $c;
	} 
	function matmul($a,$b){
		$r=count($a);
		$c=count($b[0]);
		$p=count($b);
		if(count($a)!= $p){
			echo "Incompatible matrices";
			return array(False,0);
		}
		$result=array();
		for ($i=0; $i < $r; $i++){
			for($j=0; $j < $c; $j++){
				$result[$j] = 0;
				for($k=0; $k < $p; $k++){
					$result[$j] = $result[$j] + ($a[$i] * $b[$k][$j]);
				}
			}
		}
		return array(True,$result);
		
	}


	function get_layers($config,$nl){
		$nnarc = array();
		$array = array_values($config['layers']);
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
		if((count($arr) == $ch[0]) && (count($arr[0])==$ch[1])){
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
			
			
			if($this->dim_check($weights[0][$i],array($flow[$k],$flow[$k+1]))){
				$k++;
			}
			else{
				return False;
			}
			if($bias[$k]){
				$i++;
				if(count($weights[0][$i])==$flow[$k]){
					
				}
				else{
					return False;
				}
			}
			
			
			$i++;
		
		}
		echo "Weights checked/n";
		return True;
	}

	#echo getcwd();
	
	
	function predict($testinputs){
		#global $flow,$weights,$hidn,$acti;
		if(count($testinputs)!=$this->flow[0]){
			echo "Inputs are of different shape from model";
			return;
		}
		$input = $testinputs;
		$overall = 0;
		$layew = 0;
		while($overall < count($this->weights[0])){
			$rl = $this->matmul($input,$this->weights[0][$overall]);
			if(!$rl[0]){
				echo "problem in multiplying at";
				echo $overall;
				return;
			}
			$midinp=$rl[1];
			if($this->hidn[$layew][2]){
				$overall++;
				$midinp = $this->add($midinp,$this->weights['0'][$overall]);
			}
			echo count($midinp);
			echo "-";
			$vv = $this->hidn[2][1];
			$input = $this->acti->$vv($midinp);
			$overall++;
			$layew++;
			#var_dump($input);
			#echo "end of a while";
			
		}
		return $input;
	}

	#echo count($weights['data']);
	#var_dump(predict($testinputs));
	function __construct($con,$wts) {
			$config = file_get_contents($con);
			$array = json_decode($config, true);
			$this->nlayer = count($array['layers']);
			#echo "works till here";
			$this->arc = $this->get_layers($array,$this->nlayer);
			$this->inp = $this->arc[1];
			$this->hidn = $this->arc[0];
			$this->flow = $this->arc[2];
			$this->bias = $this->arc[3];
			$wei = file_get_contents($wts);
			$this->weights = json_decode($wei, true);
			$this->acti =new acti;
			if($this->check_weights($this->weights,$this->flow,$this->bias)){
				echo "model loaded";
			}
			#var_dump($this->flow);
			#var_dump($this->hidn);
			#var_dump($this->bias);
			#var_dump($this->weights);
		}
	#$acti =new acti;
	#$vv = $hidn[2][1];
	#var_dump($acti->$vv([-1,0,2,-5]));
	#predict($testinputs)
	#echo $weights['data'][0][0][0][0]
	#echo count($weights['data'][0][0][0]);

	#var_dump($arwts);
	#echo $hidn;

}



?>