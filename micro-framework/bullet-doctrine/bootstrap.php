<?php
include __DIR__ . "/vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;


function getEntityManager()
{
    static $em = null;

    if($em == null) {
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_ROOT_PASSWORD'),
            'dbname' => getenv('MYSQL_DATABASE'),
            'host' => getenv('MYSQL_HOST')
        );


        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src/Entity"), $isDevMode, null, null, false);

        // or if you prefer yaml or XML
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);


        // obtaining the entity manager
        $em = EntityManager::create($dbParams, $config);
        //$eventManager = $entityManager->getEventManager();
        //$eventManager->addEventSubscriber(new app\events\Data());
    }
    return $em;
}