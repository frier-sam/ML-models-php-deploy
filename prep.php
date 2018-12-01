<?php
function minmax(){
	$ax = file_get_contents('files/sx.json');
	$x = json_decode($ax, true);
	var_dump($x);
}
minmax();
?>