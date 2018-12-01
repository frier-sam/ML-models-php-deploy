<?php
class test{
	var $gg;
	var $tt;
	
	function __construct($a,$b){
		
		$gg = $a;
		$tt = $b;
		
	}
	function ee(){
		global $gg;
		echo $gg;
		echo "test";
	}
	
}

$te = new test(5,3);
echo $te->ee();
echo phpversion();
?>