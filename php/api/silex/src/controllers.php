<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');

$app->get('/test', function () use ($app) {
    return $app->json([1], 200);
})->bind('homepage');

$app->get('/cliente', 'Controller\Cliente\Cliente::getAll');
$app->get('/cliente/{id}', 'Controller\Cliente\Cliente::get');
$app->post('/cliente/', 'Controller\Cliente\Cliente::create');
$app->put('/cliente/{id}', 'Controller\Cliente\Cliente::update');
$app->delete('/cliente/{id}', 'Controller\Cliente\Cliente::delete');

// $app->mount('/cliente', function ($usuario) use($app){
    // $usuario->get('/', 'Controller\Cliente\Cliente::getAll');
    // $usuario->get('/{id}', 'Controller\Cliente\Cliente::get');
    // $usuario->post('/', 'Controller\Cliente\Cliente::create');
    // $usuario->put('/{id}', 'Controller\Cliente\Cliente::update');
    // $usuario->delete('/{id}', 'Controller\Cliente\Cliente::delete');
// });

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
