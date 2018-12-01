<?php

require('nn-model.php');

$mlmod = new model('php/config.json','php/weights.json');
$testinputs = array(0.16666667,  0.        ,  0.01010101,  0.        ,  0.625     ,
         0.33333333,  1.        ,  1.14285714,  2.66666667,  0.        ,
        -0.00646353,  0.  );
var_dump($mlmod->predict($testinputs));

?>