<?php

$f3 = require('vendor/bcosca/fatfree-core/base.php');

$f3->route('GET /',
    function() {
        echo 'Hello, world!';
    }
);
$f3->run();
