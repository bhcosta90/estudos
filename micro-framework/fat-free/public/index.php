<?php
include __DIR__ . "/../vendor/autoload.php";

header('Content-Type: application/json');

$f3 = require(__DIR__ . '/../vendor/bcosca/fatfree-core/base.php');

$f3->route('GET /cliente',
    function($f3) {
        $sql = new BCosta\Classe\Select("cliente");
        $result = $sql->orderBy("nome");
        echo json_encode($result->execute());
    }
);

$f3->route('POST /cliente',
    function($f3) {
        $sql = new BCosta\Classe\Insert("cliente", ["nome" => time()]);
        $cliente = $sql->persist();

        $sql->flush();

        print json_encode([
            "status" => "S",
            "mensagem" => "Cliente cadastrado com sucesso",
            "cliente" => $cliente
        ]);
    }
);

$f3->route('PUT /cliente/@id',
    function($f3, $params) {
        $sql = new BCosta\Classe\Update("cliente", ["nome" => time()]);
        $sql->where("id=".$params["id"]);

        $cliente = $sql->persist();
        $sql->flush();

        print json_encode(["status" => "S", "mensagem" => "Cliente alterado com sucesso"]);
    }
);

$f3->route('DELETE /cliente/@id',
    function($f3, $params) {
        $sql = new BCosta\Classe\Delete("cliente");
        $sql->where("id=".$params["id"]);

        $sql->persist();
        $sql->flush();

        return print json_encode(["status" => "S", "mensagem" => "Cliente deletado com sucesso"]);
    }
);

$f3->route('GET /cliente/@id',
    function($f3, $params) {
        $sql = new BCosta\Classe\Select("cliente");
        $result = $sql->where("id=" . $params["id"]);
        echo json_encode($result->execute() ? $result->execute()[0] : ["status" => "E", "mensagem" => "Não contém mais esse cliente"]);
    }
);
$f3->run();
