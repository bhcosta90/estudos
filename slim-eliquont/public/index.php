<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

define('TEMPO', time());
define('MICRO', microtime());

$app = new Slim\App();

function validarUsuario(){
    // $login = $_SERVER["PHP_AUTH_USER"] ?? $_POST['client_login'];
    // $senha = $_SERVER["PHP_AUTH_PW"] ?? $_POST['client_password'];
    $login = $_SERVER['HTTP_AUTHORIZATION'];

    $qry = (new Usuario())->where("token", '=', $login);

    $user = $qry->first();

    return $user ?? false;
}

function getSQL($builder, $number=false) {
    $sql = $builder->toSql();
    foreach ( $builder->getBindings() as $binding ) {
        $value = is_numeric($binding) && $number==true ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}


$app->group('/usuario', function () {
    $this->post('/login', function ($request, $response, $args) {
        $login = $_SERVER["PHP_AUTH_USER"] ?? $_POST['client_login'];
        $senha = $_SERVER["PHP_AUTH_PW"] ?? $_POST['client_password'];

        $user = (new Usuario())->where("login", '=', $login)->first();
        if($user){
            $user = $user->valida($senha);
        }

        if($user){
            $user->gerarToken = 1;
            $user->save();

            return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "S",
                "mensagem" => "Usuário logado com sucesso",
                "user" => [
                    "token" => $user->token,
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
        $objUsuario = new Usuario();
        $data = $request->getParsedBody();

        $user = $objUsuario->where("login", '=', strtolower($data['login']))->first() ?? $objUsuario;

        if($user->id){
            return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode([
                "status" => "E",
                "mensagem" => "Usuário já cadastrado em nosso sistema"
            ]));
        }else{
            DB::beginTransaction();
            $user->login = strtolower($data['login']);
            $user->senha = $data["senha"];
            $user->save();
            DB::commit();

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

// $app->group('/automovel', function(){
//     $this->post('/novo', function ($request, $response, $args) {
//         if($user = validarUsuario()){
//             return $response
//             ->withStatus(200)
//             ->withHeader('Content-Type', 'application/json')
//             ->write(json_encode([
//                 "status" => "S",
//                 "mensagem" => $user->id
//             ]));
//         }else{
//             return $response
//             ->withStatus(404)
//             ->withHeader('Content-Type', 'application/json')
//             ->write(json_encode([
//                 "status" => "E",
//                 "mensagem" => "Usuário inválido",
//             ]));
//         }
//     });
// });


// $app->get('/', function() {
//     $users = Usuario::all();
//
//     foreach($users as $user){
//         print $user->login . " | " . $user->senha;
//         foreach($user->getTaxi() as $taxi){
//             print "<br />   Taxi = ".$taxi->nome;
//         }
//         print "<hr />";
//     }
// });

/*$app->get('/update', function(){
$users = Usuario::all();

try{
DB::beginTransaction();

foreach($users as $k => $user){
$user->login = $k . '-' .time();
$user->save();
}

$novo = new Usuario();
$novo->login = time();
$novo->senha = password_hash('123456', PASSWORD_DEFAULT);
$novo->save();

$automovel = new Automovel();
$automovel->id_usuario = $novo->id;
$automovel->nome = "Auto " . time();
$automovel->descricao = "testando";
$automovel->uf = "SP";
$automovel->cidade = "Americana";
$automovel->save();

// DB::commit();
}catch(\Exception $e){
print $e->getMessage();
DB::rollback();
}
});*/

$app->run();
