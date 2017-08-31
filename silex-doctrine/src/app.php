<?php

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

    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/entities"), true);
    $params = array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../development.sqlite',
    );
    $entityManager = EntityManager::create($params, $config);

    return $entityManager;
};

return $app;
