<?php
$avaliacoesUsuario = [
    'Ana'=> [
        'Freddy x Jason'=> 2.5,
        'O Ultimato Bourne'=> 3.5,
        'Star Trek'=> 3.0,
        'Exterminador do Futuro'=> 3.5,
        'Norbit'=> 2.5,
        'Star Wars'=> 3.0
    ],

    'Marcos'=>[
        'Freddy x Jason'=> 3.0,
        'O Ultimato Bourne'=> 3.5,
        'Star Trek'=> 1.5,
        'Exterminador do Futuro'=> 5.0,
        'Star Wars'=> 3.0,
        'Norbit'=> 3.5
    ],

    'Pedro'=>[
        'Freddy x Jason'=> 2.5,
        'O Ultimato Bourne'=> 3.0,
        'Exterminador do Futuro'=> 3.5,
        'Star Wars'=> 4.0
    ],

    'Claudia'=>[
        'O Ultimato Bourne'=> 3.5,
        'Star Trek'=> 3.0,
        'Star Wars'=> 4.5,
        'Exterminador do Futuro'=> 4.0,
        'Norbit'=> 2.5
    ],

    'Adriano'=>[
        'Freddy x Jason'=> 3.0,
        'O Ultimato Bourne'=> 4.0,
        'Star Trek'=> 2.0,
        'Exterminador do Futuro'=> 3.0,
        'Star Wars'=> 3.0,
        'Norbit'=> 2.0
    ],

    'Janaina'=>[
        'Freddy x Jason'=> 3.0,
        'O Ultimato Bourne'=> 4.0,
        'Star Wars'=> 3.0,
        'Exterminador do Futuro'=> 5.0,
        'Norbit'=> 3.5
    ],

    'Leonardo'=>[
        'O Ultimato Bourne'=>4.5,
        'Norbit'=>1.0,
        'Exterminador do Futuro'=>4.0
    ]
];

$avaliacoesFilme = [
    'Freddy x Jason'=>[
        'Ana'=> 2.5,
        'Marcos=>'=> 3.0 ,
        'Pedro'=> 2.5,
        'Adriano'=> 3.0,
        'Janaina'=> 3.0
    ],

    'O Ultimato Bourne'=>[
        'Ana'=> 3.5,
        'Marcos'=> 3.5,
        'Pedro'=> 3.0,
        'Claudia'=> 3.5,
        'Adriano'=> 4.0,
        'Janaina'=> 4.0,
        'Leonardo'=> 4.5
    ],

    'Star Trek'=> [
        'Ana'=> 3.0,
        'Marcos=>'=> 1.5,
        'Claudia'=> 3.0,
        'Adriano'=> 2.0
    ],

    'Exterminador do Futuro'=> [
        'Ana'=> 3.5,
        'Marcos=>'=> 5.0 ,
        'Pedro'=> 3.5,
        'Claudia'=> 4.0,
        'Adriano'=> 3.0,
        'Janaina'=> 5.0,
        'Leonardo'=> 4.0
    ],

    'Norbit'=> [
        'Ana'=> 2.5,
        'Marcos=>'=> 3.0 ,
        'Claudia'=> 2.5,
        'Adriano'=> 2.0,
        'Janaina'=> 3.5,
        'Leonardo'=> 1.0
    ],

    'Star Wars'=> [
        'Ana'=> 3.0,
        'Marcos=>'=> 3.5,
        'Pedro'=> 4.0,
        'Claudia'=> 4.5,
        'Adriano'=> 3.0,
        'Janaina'=> 3.0
    ]
];

function debug($a){
    print "<pre>";
    print_r($a);
    print "</pre>";
}

function euclidiana($variavel, $usuario1, $usuario2){
    $si = [];

    foreach($variavel[$usuario1] as $item => $v){
        if( array_key_exists($item, $variavel[$usuario2]) ) {
            $si[$item] = 1;
        };
    }

    if(count($si)==0) return 0;

    $retorno = [];

    foreach($variavel[$usuario1] as $item => $v){
        if(array_key_exists($item, $variavel[$usuario2])){
            $si[$item] = 1;
            $retorno [] = pow($variavel[$usuario1][$item] - $variavel[$usuario2][$item], 2);
        }
    }

    $retorno = array_sum($retorno);

    return 1 / (1 + sqrt($retorno) );
}

function getSimilares($variavel, $usuario){

    $retorno = [];

    foreach($variavel as $outro => $v){
        if($outro != $usuario){
            $retorno[$outro] = euclidiana($variavel, $usuario, $outro);
        }
    }

    arsort($retorno);

    return array_slice($retorno, 0, 30);
}

function getRecomendacaoUsuario($variavel, $usuario){
    $retorno = [];
    $totais = [];
    $somaSimilaridade = [];

    foreach($variavel as $outro => $v){
        if($outro == $usuario) continue;

        $similaridade = euclidiana($variavel, $usuario, $outro);
        if($similaridade <= 0) continue;

        foreach($variavel[$outro] as $item => $v2){
            if(!array_key_exists($item, $variavel[$usuario])){
                $totais[$item] += $variavel[$outro][$item] * $similaridade;
                $somaSimilaridade[$item] += $similaridade;
            }
        }
    }

    foreach($totais as $item => $total){
        #(total / somaSimilaridade[item], item)
        $retorno[$item] = $total / $somaSimilaridade[$item];
    }

    arsort($retorno);

    return array_splice($retorno, 0, 30);
}

function carregar(){
    $arrayFilmes = [];
    $arrayUsuario = [];
    $retorno = [];

    $filmes = fopen(getcwd() . "/data/u.item", "r");

    while (!feof ($filmes)) {
        $linha = fgets($filmes, 4096);
        list($id, $titulo) = explode("|", $linha);
        $arrayFilmes[$id] = $titulo;
    }

    fclose ($filmes);

    $usuarios = fopen(getcwd() . "/data/u.data", "r");

    while (!feof ($usuarios)) {
        $linha = fgets($usuarios, 4096);
        list($usuario, $idFilme,  $nota, $tempo) = explode("\t", $linha);

        $retorno[$usuario][$arrayFilmes[$idFilme]] = floatval($nota);
    }

    fclose ($usuarios);
    return $retorno;
}

function calculaItensSimilares($variavel){
    $retorno = [];
    foreach($variavel as $item => $v ){
        $notas = getSimilares($variavel, $item);

        $retorno[$item] = $notas;
    }

    return $retorno;
}

function getRecomendacoesItens($baseUsuario, $similaridadeItens, $usuario){
    $notasUsuario = $baseUsuario[$usuario];
    $notas = [];
    $totalSimilaridade = [];
    $retorno = [];

    foreach($notasUsuario as $item => $nota){
        foreach($similaridadeItens[$item] as $item2 => $similaridade){
            if (array_key_exists($item2, $notasUsuario)) continue;

            $notas[$item2] += $similaridade * $nota;
            $totalSimilaridade[$item2] += $similaridade;
        }
    }

    foreach($notas as $item => $total){
        #(total / somaSimilaridade[item], item)
        $retorno[$item] = $total / $totalSimilaridade[$item];
    }

    arsort($retorno);

    return $retorno;
}

// debug(euclidiana($avaliacoesUsuario, "Ana", "Leonardo"));
// debug(getSimilares($avaliacoesUsuario, "Leonardo"));
// debug(getRecomendacaoUsuario($avaliacoesUsuario, "Leonardo"));
// debug(calculaItensSimilares($avaliacoesFilme));
// debug(getRecomendacoesItens($avaliacoesUsuario, calculaItensSimilares($avaliacoesFilme), "Leonardo"));

?>
