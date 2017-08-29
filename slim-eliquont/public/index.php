<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;


$app = new Slim\App();

function getSQL($builder, $number=false) {
    $sql = $builder->toSql();
    foreach ( $builder->getBindings() as $binding ) {
        $value = is_numeric($binding) && $number==true ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}

$app->get('/', function() {
    $users = Usuario::all();

    foreach($users as $user){
        print $user->login . " | " . $user->senha;
        foreach($user->getTaxi() as $taxi){
            print "<br />   Taxi = ".$taxi->nome;
        }
        print "<hr />";
    }
});

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
