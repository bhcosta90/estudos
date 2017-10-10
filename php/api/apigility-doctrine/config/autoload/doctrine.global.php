<?php

/*return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver',
                'params' => array(
                    'path' => 'data/database.sqlite'
                )
            )
        )
    )
);//*/


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
                    'dbname' => "test_api",
                    'driverOptions' => [1002 => 'SET NAMES utf8'],
                ]
            ]
        ]
    ]
];//*/
