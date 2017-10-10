<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->post('/produtos/{q}', function ($q) use ($app) {
    $client = new \GuzzleHttp\Client();

    $res = $client->request('POST', 'http://10.70.2.30:9200/kabumtogo/produtos/_search', [
        'json' => [
            "query"=> [
                "function_score"=> [
                    "query"=> [
                        "bool"=> [
                            "should"=> [
                                [
                                    "match"=> [
                                        "auto_completar"=> [
                                            "query"=> $q
                                        ]
                                    ]
                                ],
                                [
                                    "term"=> [
                                        "codigo"=> [
                                            "value"=>'',
                                            "boost"=> 100
                                        ]

                                    ]
                                ],
                                [
                                    "match_phrase"=> [
                                        "nome"=> [
                                            "query"=> $q,
                                            "boost"=> 8
                                        ]
                                    ]
                                ],
                                [
                                    "match_phrase"=> [
                                        "marca"=> [
                                            "query"=> $q,
                                            "boost"=> 6
                                        ]
                                    ]
                                ],

                                [
                                    "match_phrase"=> [
                                        "descricao"=> $q
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "script_score" => [
                        "script" => [
                            "inline" => "_score - (doc.tmp_ranking.value + doc.disponibilidade.value)"
                        ]
                    ],
                    "boost_mode"=> "sum"
                ]
            ],
            "size"=>'30',
            "from"=>'0'
        ],
    ]);

    $produtos = json_decode($res->getBody(), true);
    $retorno = [];

    foreach($produtos['hits']['hits'] as $p){
        array_push($retorno, [
            "codigo" => $p["_id"],
            "nome" => $p["_source"]["nome"]
        ]);
    }

    $retorno = [
        "total" => $produtos['hits']['total'],
        "time" => $produtos['took'],
        "results" => $retorno,
    ];

    header('Content-Type: application/json');
    print json_encode($retorno);

    exit;
})
->bind('homepage')
;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
