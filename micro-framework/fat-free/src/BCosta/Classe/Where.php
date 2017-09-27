<?php

namespace BCosta\Classe;

class Where{
    private static $contador;
    protected function gerarWhere($contador, $tipoRetorno, $part1)
    {
        $where = "";
        $i = self::$contador = $contador;
        $variaveis = array();

        if ($tipoRetorno == "array") {
            if (is_array($part1) == false) {
                $json = new Json();
                $json->erroCampo("e", "O filtro não está como array no arquivo: {$_SERVER["PHP_SELF"]}");
                $json->imprimir();
                exit();
            }
        }

        foreach ($part1 as $idParte => $parte) {
            if (is_array($parte) == false) {
                /*
                 * verifica qual operador lógico entre campos
                 */
                $operadorLogico = substr($parte, 0, 1);
                $op = "";
                if ($idParte > 0) {
                    if ($operadorLogico == "|") {
                        $op = "OR";
                        $parte = substr($parte, 1);
                    }
                    if ($operadorLogico == "&") {
                        $op = "AND";
                        $parte = substr($parte, 1);
                    }
                } else {
                    if ($operadorLogico == "|") {
                        $parte = substr($parte, 1);
                    }
                    if ($operadorLogico == "&") {
                        $parte = substr($parte, 1);
                    }
                }
                /*
                 *
                 * verifica operador matemático
                 * <>   = Diferente
                 * <=   = Maior igual
                 * >=   = Menor igual
                 * >    = Maior
                 * <    = Menor
                 * =    = Igual
                 * ~~   = LIKE
                 * ~~*  = ILIKE
                 * ¬    = is (campo¬isnull ou campo¬isnotnull)
                 * #    = Betweewn  (Tem mais um argumento que deve passar no caso internamente, para separar os valores utiliza-se & ou | sendo: & = AND | OR)
                 */
                $operadorMatematico = array("¬", "#", "<>", "<=", ">=", ">", "<", "=", "~~", "~~*");

                foreach ($operadorMatematico as $operadorArray) {
                    $operador = strpos(strtolower($parte), $operadorArray);
                    if ($operador > 0) {

                        $operadorArray = "";
                        $numeroPrimeiroOperador = 0;
                        foreach ($operadorMatematico as $valueOperador) {
                            $numberPosicaoOperador = strpos(strtolower($parte), $valueOperador);
                            if ($numberPosicaoOperador > 0) {
                                if ($numeroPrimeiroOperador == 0 || $numberPosicaoOperador < $numeroPrimeiroOperador) {
                                    $numeroPrimeiroOperador = $numberPosicaoOperador;
                                    $operadorArray = $valueOperador;
                                }
                            }
                        }
                        $part2 = explode($operadorArray, $parte);
                        if (substr($part2[1], 0, 1) == "*") {
                            $part2[1] = substr($part2[1], 1);
                            if ($operadorArray == "~~") {
                                $operadorArray .= "*";
                            }
                        }
                        if ($tipoRetorno == "array") {
                            if (($operadorArray == "~~") || ($operadorArray == "~~*")) {
                                if ($operadorArray == "~~") {
                                    $like = "LIKE";
                                } else {
                                    $like = "ILIKE";
                                }
                                $where .= " $op acento($part2[0]::text) {$like} acento(:valor".self::$contador.") ";
                                $valor = trim($part2[1]);
                                $valor = str_replace(array(" ", "*"), "%", $valor);
                                $valor = "{$valor}";
                                // array_push($variaveis, $valor);
                                $variaveis[":valor".self::$contador] = $valor;
                                self::$contador++;
                            } else {
                                if ($operadorArray == '¬') {
                                    $where .= " $op $part2[0] $part2[1] ";
                                } else if ($operadorArray == "#") {
                                    $between = $part2[1];
                                    $operacao = explode('&', $between);
                                    $operacaoTXT = array();
                                    if (count($operacao) > 1) {
                                        $operacaoTXT[] = $operacao[0];
                                        $operacaoTXT[] = $operacao[1];
                                        $operacao = "AND";
                                    } else {
                                        $operacao = explode('|', $between);
                                        if (count($operacao) > 1) {
                                            $operacaoTXT[] = $operacao[0];
                                            $operacaoTXT[] = $operacao[1];

                                            $operacao = "OR";
                                        } else {
                                            $operacao = null;
                                        }
                                    }
                                    if ($operacao != null) {
                                        $where .= "$op $part2[0] BETWEEN  {$operacaoTXT[0]} {$operacao} {$operacaoTXT[1]} ";
                                    }
                                } else {
                                    $where .= " $op $part2[0] $operadorArray :valor".self::$contador." ";
                                    $valor = $part2[1];
                                    // array_push($variaveis, $valor);
                                    $variaveis[":valor".self::$contador] = $valor;
                                    self::$contador++;
                                }
                            }
                            break;
                        } else {
                            $valor = $part2[1];
                            $valor = str_replace(" ", "%", $valor);
                            $valor = "{$valor}";
                            $where .= " $op $part2[0]::text ILIKE '$valor' ";
                            self::$contador++;
                            break;
                        }
                    }
                }
            } else {
                if (count($parte) > 0) {
                    $gerarWhere = $this->gerarWhere(self::$contador, $tipoRetorno, $parte);
                    $operadorLogico = substr($parte[0], 0, 1);
                    $op = "";
                    if ($idParte > 0) {
                        if ($operadorLogico == "|") {
                            $op = "OR";
                        }
                        if ($operadorLogico == "&") {
                            $op = "AND";
                        }
                    }
                    $where .= "{$op} ({$gerarWhere["where"]})";
                    $variaveis = array_merge($variaveis, $gerarWhere["variavel"]);
                    self::$contador = $gerarWhere["total"];
                }
            }
        }

        return array(
            "where" => str_replace("  "," ", $where),
            "variavel" => $variaveis,
            "total" => self::$contador
        );
    }

    public function where($filtro, $contador, $tipoRetorno = 'array')
    {
        if (is_array($filtro) == false) {
            $part1 = explode("/", $filtro);
        } else {
            $part1 = $filtro;
        }

        $gerar = $this->gerarWhere($contador, $tipoRetorno, $part1);

        if ($tipoRetorno == "array") {
            $return = array($gerar["where"], $gerar["variavel"]);
        } else {
            $return = $gerar["where"];
        }
        return $return;
    }
}

?>
