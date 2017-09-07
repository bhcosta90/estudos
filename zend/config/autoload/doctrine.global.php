<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host' => 'db',
                    'port' => "3306",
                    'user' => "root",
                    'password' => "root",
                    'dbname' => "doctrine",
                    'driverOptions' => [1002 => 'SET NAMES utf8'],
                ]
            ]
        ],
        "limit" => 25,
    ]
];