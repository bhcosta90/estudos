<?php
namespace BCosta\Classe;

class Insert extends Banco{
    public function __construct($tabela, array $dados, $aspas = true){

        $prepare = "u" . $tabela;
        $prepare = explode('.', $prepare);
        if (count($prepare) > 1) {
            $prepare = $prepare[1];
        } else {
            $prepare = $prepare[0];
        }

        $i = 0;
        $campos = "";
        $variaveis = "";
        $dados_variavel = [];

        foreach ($dados as $chave => $valor) {
            if ($aspas === true) {
                $valor = str_replace(array('"', "'"), array("&#34;", "&#39;"), $valor);
                $valor = trim($valor);
            }

            if (($valor == 'NULL') OR ($valor == NULL)) {
                $dados_variavel[":campo".$i] = NULL;
            } else {
                $dados_variavel[":campo".$i] = $valor;
            }

            $campo = ($chave);
            $campos .= "$campo, ";
            $variaveis .= ":campo$i, ";
            $i++;
        }
        $campos = substr($campos, 0, -2);
        $variaveis = substr($variaveis, 0, -2);

        $sql = "INSERT INTO $tabela ( $campos ) VALUES ( $variaveis )";

        $this->dados["sql"] = $sql;
        $this->dados["variavel"] = $dados_variavel;
    }
}
?>
