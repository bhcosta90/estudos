<?php
namespace BCosta\Classe;

class Update extends Banco{
    public function __construct($tabela, array $dados){
        $i = 0;
        $query = "";

        $dados_variavel = [];

        $i = 0;
        foreach ($dados as $chave => $valor) {
            if (is_string($valor)) {
                if ($aspas === true) {
                    $valor = str_replace(array('"', "'"), array("&#34;", "&#39;"), $valor);
                    $valor = trim($valor);
                }
                if ($valor == "") {
                    $valor = null;
                }
            }
            $dados_variavel[":campo".$i] = $valor;

            $campo = $chave;
            $query .= "{$campo} = :campo".$i . ", ";
            $i++;
        }
        $query = substr($query, 0, -2);

        $sql = "UPDATE $tabela SET $query";

        $this->dados["sql"] = $sql;
        $this->dados["variavel"] = $dados_variavel;
    }

    public function where($filtro=null){
        if($filtro){
            $w = new \BCosta\Classe\Where;

            $where_retorno = $w->where($filtro, 0);
            $where = $where_retorno[0];
            $where_variaveis = $where_retorno[1];

            $this->dados["where"][] = [
                "sql" => $where,
                "variavel" => $where_variaveis,
            ];
        }

        return $this;
    }
}
?>
