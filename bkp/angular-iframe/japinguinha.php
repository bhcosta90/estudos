<?php
$x = 'xxxx';
$y = 'yyyy';

// print "$x | $y<br />";
//
// $x = $y + $x;
// $y = $x - $y;
// $x = $x - $y;
//
// print "$x | $y<br />";

$x = "$x|$y";
// $y = explode('|', $x);
// $x = $y[0];
// $y = $y[1];
list($y, $x) = explode('|', $x);

print "$x | $y<br />";

$server_seed = "48e2d711de45f14bdb2348f33f7cd8b0ed1413fdb587127716611be7da21b741";
$round_id = "1";
$hash = hash("sha256",$server_seed."-".$round_id);
$roll = hexdec(substr($hash,0,8)) % 54;
echo "Round $round_id = $roll";

?>
