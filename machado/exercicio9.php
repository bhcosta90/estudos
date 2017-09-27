<?php

$lado1 = $argv[1];
$lado2 = $argv[2];
$lado3 = $argv[3];


if($lado1 == $lado2 && $lado2 == $lado3){
  print "equilátero";
}elseif(($lado1 == $lado2 && $lado2 != $lado3) || $lado1 != $lado2 && $lado2 == $lado3 || $lado1 != $lado2 && $lado1 == $lado3){
  print "isósceles";
}else{
  print "escaleno";
}
print "\n";

?>
