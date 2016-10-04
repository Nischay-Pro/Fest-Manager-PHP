<?php
$a = strtotime("2016-09-30 04:03:06");
	$b = strtotime(date("Y-m-d G:i:s"));
$d = strtotime("2016-09-30 00:48:06");
// $b = Date('U');
echo $b;
echo " ";
echo "D".$d."D";
$c = $b + 21600 - $d;
//+21600;
echo "Here".$c."Here";
?>