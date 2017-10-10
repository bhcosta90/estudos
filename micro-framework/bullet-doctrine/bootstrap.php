<?php
include __DIR__ . "/vendor/autoload.php";

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

        $paths = [
            __DIR__ . '/Entity'
        ];


        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver($paths, false);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(__DIR__. '/.data/proxy');
        $config->setProxyNamespace('SON\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $em = \Doctrine\ORM\EntityManager::create($dbParams,$config);
    }
    return $em;
}