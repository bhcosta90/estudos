<?php
namespace BCosta\Classe;

class Delete extends Banco{
    public function __construct($tabela){
        $i = 0;
        $query = "";

        $sql = "DELETE FROM $tabela";

        $this->dados["sql"] = $sql;
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
