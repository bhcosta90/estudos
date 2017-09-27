<?php

$lado1 = $argv[1];
$lado2 = $argv[2];

$tLado1 = 0;
for($i = 0; $i < $lado2; $i++){
  $tLado1 = $tLado1 + $lado1;
}

print $tLado1."\n";
?>
