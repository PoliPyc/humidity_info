<?php 
$data = file_get_contents('humidity.csv');

function getLastLines($string, $n = 1) {
	    $lines = explode("\n", $string);

	        $lines = array_slice($lines, -$n);

	        return implode("<br />", $lines);
}

echo getLastLines($data, 5);
