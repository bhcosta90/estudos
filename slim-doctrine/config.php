<?php
require 'vendor/autoload.php';

// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager;


$isDevMode = true;

$conn = array(
    'driver' => 'pdo_mysql',
    'user'=>'root',
    'password'=>'root',
    'dbname'=>'doctrine',
    'host' => 'db',
);

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/app/entities"), $isDevMode);

// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);


// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
$eventManager = $entityManager->getEventManager();
$eventManager->addEventSubscriber(new app\events\Data());

function getEm(){
    global $entityManager;
    return $GLOBALS['entityManager'];
}
?>
