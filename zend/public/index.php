<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;
use Swagger\Annotations as SWG;

error_reporting(E_ALL && E_WARNING);
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run zf composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}
function tempoExecucao($start = null) {
    // Calcula o microtime atual
    $mtime = microtime(); // Pega o microtime
    $mtime = explode(' ',$mtime); // Quebra o microtime
    $mtime = $mtime[1] + $mtime[0]; // Soma as partes montando um valor inteiro
    if ($start == null) {
        // Se o parametro n�o for especificado, retorna o mtime atual
        return $mtime;
    } else {
        // Se o parametro for especificado, retorna o tempo de execu��o
        return round($mtime - $start, 2);
    }
}

define('MICRO', tempoExecucao());
define('TEMPO', floatval(time()));

// Run the application!
Application::init($appConfig)->run();
