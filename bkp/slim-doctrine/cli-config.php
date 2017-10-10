<?php
include "config.php";
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(getEm());
?>
