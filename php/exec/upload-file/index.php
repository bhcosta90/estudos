<?php

$imagem = file_get_contents('mensageiro.jpg');

$data = [
    "arquivo" => base64_encode($imagem),
    "size" => [
        [
            "name" => [
                "begin" => "10",
                "end" => "gg"
            ],
            "size" => "1000",
            "white" => true,
            "extension" => ".jpg",
            "path" => "/produtos/" . time(),
        ],
        [
            "name" => [
                "begin" => "10",
                "end" => "g"
            ],
            "size" => "800",
            "white" => true,
            "extension" => ".jpg",
            "path" => "/produtos/" . time(),
        ],
        [
            "name" => [
                "begin" => "10",
                "end" => "original"
            ],
            "extension" => ".jpg",
            "path" => "/produtos/".time(),
        ]
    ]
];
$data_string = json_encode($data);

$ch = curl_init('http://localhost/upload');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);

print $result;

?>
