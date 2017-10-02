<?php
include "vendor/autoload.php";

$client = new Predis\Client('tcp://redis:6379');
$value = $client->get('foo');
$tempo = time();

if(!$value){
    $client->set('foo', time());
    $client->expireat('foo', strtotime("+5 second"));
    print "Atribuiu: ";
}else{
    $tempo = $value;
}

print $tempo;
