<?php

$idade1 = $argv[1];
$idade2 = $argv[2];

if($idade1 < $idade2){
  print "Primeira idade: $idade1 \nSegunda idade: $idade2";
}elseif($idade1 > $idade2){
  print "Primeira idade: $idade2 \nSegunda idade: $idade1";
}else{
  print "As duas idades são iguais";
}
print "\n";

?>
