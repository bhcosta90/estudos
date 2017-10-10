<?php

function tempoExecucao($start = null) {
    // Calcula o microtime atual
    $mtime = microtime(); // Pega o microtime
    $mtime = explode(' ',$mtime); // Quebra o microtime
    $mtime = $mtime[1] + $mtime[0]; // Soma as partes montando um valor inteiro
    if ($start == null) {
        // Se o parametro não for especificado, retorna o mtime atual
        return $mtime;
    } else {
        // Se o parametro for especificado, retorna o tempo de execução
        return round($mtime - $start, 2);
    }
}

define('MICRO', tempoExecucao());
define('TEMPO', floatval(time()));

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app['em'] = function () {

    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/entities"), true);
    $params = array(
        // 'driver' => 'pdo_sqlite',
        // 'path' => __DIR__ . '/../var/development.sqlite',
        'driver' => 'pdo_mysql',
        'user'=>'root',
        'password'=>'root',
        'dbname'=>'doctrine',
        'host' => 'db',
    );
    $entityManager = EntityManager::create($params, $config);

    $eventManager = $entityManager->getEventManager();
    $eventManager->addEventSubscriber(new src\events\Data());


    return $entityManager;
};

return $app;
