<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new Bullet\App([
    // 'template' => array(
    //     'path' => APP_DIR . 'templates',
    //     'cache' => APP_DIR . 'templates/cache',
    //     'default_extension' => 'php',
    // )
]);

$app->path('/cliente', function($request) use ($app) {
    $app->get(function($request) use($app) {

        $app->format('json', function($request) use($app) {
            $sql = new BCosta\Classe\Select("cliente");

            return $sql
            ->orderBy("nome asc")
            // ->where(["nome=teste", "&nome=teste2", ["&nome=teste3"] ])
            // ->limit(10)
            // ->offset(0)
            ->execute();
        });
    });

    $app->post(function() use($app){
        $sql = new BCosta\Classe\Insert("cliente", ["nome" => time()]);
        $cliente = $sql->persist();

        $sql->flush();

        return $app->response(201, [
            "status" => "S",
            "mensagem" => "Cliente cadastrado com sucesso",
            "cliente" => $cliente
        ]);
    });

    $app->param('int', function($request, $id) use($app) {

        $app->get(function($request) use($app, $id) {
            $sql = new BCosta\Classe\Select("cliente");
            $result = $sql->where("id=" . $id);
            return $result->execute() ? $result->execute()[0] : $app->response(404, ["status" => "E", "mensagem" => "Não contém mais esse cliente"]);
        });

        $app->put(function($request) use($app, $id) {
            $sql = new BCosta\Classe\Update("cliente", ["nome" => time()]);
            $sql->where("id=".$id);

            $cliente = $sql->persist();
            $sql->flush();

            return $app->response(200, ["status" => "S", "mensagem" => "Cliente alterado com sucesso"]);
        });

        $app->delete(function($request) use($app, $id) {
            $sql = new BCosta\Classe\Delete("cliente", ["nome" => time()]);
            $sql->where("id=".$id);

            $sql->persist();
            $sql->flush();

            return $app->response(202, ["status" => "S", "mensagem" => "Cliente deletado com sucesso"]);
        });
    });
});

// Run the app! (takes $method, $url or Bullet\Request object)
echo $app->run(new Bullet\Request());
