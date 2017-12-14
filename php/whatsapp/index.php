<?php 
include "vendor/autoload.php";
// include "vendor/whatsapp/chat-api/src/Registration.php";

$username = "+5519987209627";
$nickname = "Bruno Costa";
$password = ""; // The one we got registering the number
$debug = true;

// $r = new Registration($username, $debug);
// $r->codeRequest('sms');
// $r->codeRegister('123456');

// Create a instance of WhastPort.
$w = new WhatsProt($username, $nickname, $debug);
    
$w->connect();

$target = '+5519988745124'; // The number of the person you are sending the message
$message = 'Hi! :) this is a test message';

$w->sendMessage($target, $message);
$w->pollMessage();
?>