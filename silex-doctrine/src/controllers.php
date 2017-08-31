<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use src\entities\Usuario;

function getEm(){
    $app = $GLOBALS['app'];
    return $app['em'];
}

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');

$app->mount('/usuario', function ($usuario) use($app){
    $usuario->post('/novo', function (Request $request) use($app){


        $email = strtolower($request->get("login"));
        $user = getEm()->getRepository(Usuario::class)->findOneByLogin($email) ?? new Usuario();

        if($user->getId()){
            return new Response(json_encode([
                "status" => "E",
                "mensagem" => "Usuário já cadastrado em nosso sistema",
                "tempo" => [
                    "total" => tempoExecucao(MICRO),
                    "inicio" => MICRO,
                    "fim" => floatval(microtime())
                ]
            ]), 403, ['Content-Type' => 'application/json']);

        }else{
            $user->setLogin($email);
            $user->setSenha($request->get("senha"));

            getEm()->persist($user);
            getEm()->flush();

            return new Response(json_encode([
                "status" => "S",
                "mensagem" => "Usuário cadastrado com sucesso",
                "tempo" => [
                    "total" => tempoExecucao(MICRO),
                    "inicio" => MICRO,
                    "fim" => floatval(microtime())
                ]
            ]), 200, ['Content-Type' => 'application/json']);
        }
    });
});

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
