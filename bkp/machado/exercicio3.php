<?php

$lado1 = $argv[1] * 100;
$lado2 = $argv[2] * 100;

$parede = $lado1 * $lado2;
$foto = 50 * 80;

print floor($parede / $foto). " fotos\n"; #floor irá arredondar o valor para baixo

?>
