<?php

namespace Controller\Cliente;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Cliente{
    function getAll(Request $request, Application $app){
        return $app->json([1], 200);
    }

    function get(Request $request, Application $app, int $id){
        $dados = $app['db']->get("cliente", [
            "id",
            "nome"
        ], [
            "id[=]" => $id
        ]);

        return $app->json($dados, 200);
    }

    function create(Request $request, Application $app){
        $dados = [
            "nome" => time(),
        ];

        $app['db']->insert("cliente", $dados);

        return $app->json($dados, 200);
    }

    function update(Request $request, Application $app, int $id){
        $dados = [
            "nome" => time(),
        ];

        $app['db']->update("cliente", $dados, [
            "id[=]" => $id
        ]);

        return $app->json($dados, 200);
    }

    function delete(Request $request, Application $app, int $id){
        $app['db']->delete("cliente", [
            "id[=]" => $id
        ]);

        return $app->json([1], 200);
    }
}

?>
