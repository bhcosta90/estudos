<?php
namespace BCosta\Classe;

class Select extends Banco{
    public function __construct($tabela, $campos="*"){
        if (is_array($tabela) == false) {
            $t = explode(' ', $tabela);
            $prepare = "u" . $t[0];
            $prepare = explode('.', $prepare);
            if (count($prepare) > 1) {
                $prepare = $prepare[1];
            } else {
                $prepare = $prepare[0];
            }
        } else {
            $prepare = "u" . $tabela[0];
        }

        /*
        * CAMPOS
        */
        $query = "";
        if(is_array($campos)){
            foreach ($campos as $campo) {
                if ($campo) {
                    $query .= "$campo, ";
                }
            }
        }else {
            $query .= "*, ";
        }
        $query = substr($query, 0, -2);

        $sql = "SELECT {$query} FROM $tabela";

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
                "variavel" => $where_variaveis
            ];
        }

        return $this;
    }

    public function orderBy($string){
        $this->dados["order"][] = $string;
        return $this;
    }

    public function groupBy($string){
        $this->dados["group"][] = $string;
        return $this;
    }
}
?>
