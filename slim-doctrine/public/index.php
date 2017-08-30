<?php
require __DIR__.'/../config.php';

define('TEMPO', time());
define('MICRO', microtime());

use \app\entities\Usuario;

$app = new Slim\App();

function validarUsuario(){
    // $login = $_SERVER["PHP_AUTH_USER"] ?? $_POST['client_login'];
    // $senha = $_SERVER["PHP_AUTH_PW"] ?? $_POST['client_password'];
    $login = $_SERVER['HTTP_AUTHORIZATION'];

    $qry = getEm()->getRepository(app\entities\Usuario::class)->findOneByToken(strtolower($data['login']));

    $user = $qry->first();

    return $user ?? false;
}

$app->group('/usuario', function () {
    $this->post('/login', function ($request, $response, $args) {

        $login = $_SERVER["PHP_AUTH_USER"] ?? $_POST['client_login'];
        $senha = $_SERVER["PHP_AUTH_PW"] ?? $_POST['client_password'];

        $user = getEm()->getRepository(Usuario::class)->findOneByLogin($login);
        if($user){
            $user = $user->valida($senha);
        }

        if($user){
            getEm()->getConnection()->beginTransaction();
            $user->setToken(rand(1,9999));
            getEm()->flush();
            getEm()->getConnection()->commit();

            return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "S",
                "mensagem" => "Usuário logado com sucesso",
                "user" => [
                    "token" => $user->getToken(),
                ],
            ]));
        }else{
            return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "E",
                "mensagem" => "Usuário inválido"
            ]));
        }
    });

    $this->post('/novo', function ($request, $response, $args) {
        $data = $request->getParsedBody();

        $user = getEm()->getRepository(Usuario::class)->findOneByLogin(strtolower($data['login'])) ?? new app\entities\Usuario();

        if($user->getId()){
            return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "E",
                "mensagem" => "Usuário já cadastrado em nosso sistema"
            ]));
        }else{

            $user->setLogin($data["login"]);
            $user->setSenha($data["senha"]);

            getEm()->persist($user);
            getEm()->flush();

            return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "S",
                "mensagem" => "Usuário cadastrado com sucesso",
                "tempo" => [
                    "total" => microtime() - MICRO,
                    "inicio" => MICRO,
                    "fim" => microtime()
                ]
            ]));
        }
    });
});

$app->run();
?>
