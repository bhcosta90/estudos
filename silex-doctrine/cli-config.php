<?php
$app = include "src/app.php";
print_r($app); exit;
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app['em']);
?>
