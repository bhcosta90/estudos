<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new Bullet\App([
]);

function getEm(){
    static $conn;

    if($conn===null){
        $conn = new \Medoo\Medoo([
            // required
            'database_type' => 'mysql',
            'database_name' => 'doctrine',
            'server' => 'db',
            'username' => 'root',
            'password' => 'root',

            // [optional]
            'charset' => 'utf8',
            'port' => 3306,

            // [optional] Table prefix
            'prefix' => '',

            // [optional] Enable logging (Logging is disabled by default for better performance)
            'logging' => true,

            // [optional] MySQL socket (shouldn't be used with server and port)
            // 'socket' => '/tmp/mysql.sock',

            // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
            'option' => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ],

            // [optional] Medoo will execute those commands after connected to the database for initialization
            'command' => [
                'SET SQL_MODE=ANSI_QUOTES'
            ]
        ]);
    }
    return $conn;
}

getEm();

$app->path('/cliente', function($request) use ($app) {
    $app->get(function($request) use($app) {

        $app->format('json', function($request) use($app) {
            $dados = getEm()->select("cliente", [
                "id",
                "nome"
            ], [
                "id[>]" => 0
            ]);

            return $app->response(404, ["status" => "S", "dados" => $dados]);
        });
    });

    $app->post(function() use($app){
        getEm()->action(function($database) {
            for($i =0; $i < 100; $i++)
                $database->insert("cliente", [
                    "nome" => time(),
                ]);
        });

        return $app->response(404, ["status" => "S", "id" => getEm()->id()]);
    });

    $app->param('int', function($request, $id) use($app) {

        $app->get(function($request) use($app, $id) {

            $dados = getEm()->get("cliente", [
                "id",
                "nome"
            ], [
                "id[=]" => $id
            ]);

            return $dados ? $app->response(200, $dados) : $app->response(404, ["status" => "E", "mensagem" => "Não contém mais esse cliente"]);
        });

        $app->put(function($request) use($app, $id) {
            getEm()->update("cliente", [
                "nome" => time(),
            ], [
                "id[=]" => $id
            ]);

            return $app->response(200, ["mensagem" => "Cliente atualizado"]);
        });

        $app->delete(function($request) use($app, $id) {
            getEm()->delete("cliente", [
                "id[=]" => $id
            ]);
            return $app->response(404, ["status" => "E", "mensagem" => "Não contém mais esse cliente"]);
        });
    });
});

// Run the app! (takes $method, $url or Bullet\Request object)
echo $app->run(new Bullet\Request());
