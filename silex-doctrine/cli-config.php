<?php
$app = include "src/app.php";
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app['em']);
?>
