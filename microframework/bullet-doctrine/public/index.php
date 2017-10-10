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
            $serializer = JMS\Serializer\SerializerBuilder::create()->build();
            $jsonContent = $serializer->serialize(getEntityManager()->getRepository(\Entity\Cliente::class)->findAll(), 'json');
            return $app->response(200, $jsonContent);
        });
    });

    $app->post(function() use($app){
        $cliente = new \Entity\Cliente();
        $cliente->setNome(time()."");

        getEntityManager()->persist($cliente);
        getEntityManager()->flush();

        return $app->response(201, [
            "status" => "S",
            "mensagem" => "Cliente cadastrado com sucesso",
            "cliente" => $cliente->getId()
        ]);
    });

    $app->param('int', function($request, $id) use($app) {

        $app->get(function($request) use($app, $id) {
            $serializer = JMS\Serializer\SerializerBuilder::create()->build();
            try{
                $jsonContent = $serializer->serialize(getEntityManager()->getReference(\Entity\Cliente::class, $id), 'json');
                return $app->response(201, $jsonContent);
            }catch (Exception $e){
                return $app->response(404, ["status" => "E", "mensagem" => $e->getMessage()]);
            }
        });

        $app->put(function($request) use($app, $id) {
            $cliente = getEntityManager()->getReference(\Entity\Cliente::class, $id);
            $cliente->setNome(time());
            getEntityManager()->flush();

            return $app->response(200, ["status" => "S", "mensagem" => "Cliente alterado com sucesso"]);
        });

        $app->delete(function($request) use($app, $id) {
            $cliente = getEntityManager()->getReference(\Entity\Cliente::class, $id);
            getEntityManager()->remove($cliente);
            getEntityManager()->flush();

            return $app->response(202, ["status" => "S", "mensagem" => "Cliente deletado com sucesso"]);
        });
    });
});

// Run the app! (takes $method, $url or Bullet\Request object)
echo $app->run(new Bullet\Request());
