<?php
return [
    'doctrine' => [
        'driver' => [
            'Automovel_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Automovel\\Entity' => 'Automovel_driver',
                ],
            ],
        ],
        'fixtures' => [],
    ],
    'service_manager' => [
        'factories' => [
            \Automovel\V1\Rest\Automovel\AutomovelResource::class => \Automovel\V1\Rest\Automovel\AutomovelResourceFactory::class,
            \Automovel\V1\Rest\Usuario\UsuarioResource::class => \Automovel\V1\Rest\Usuario\UsuarioResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'automovel.rest.automovel' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/automovel[/:automovel_id]',
                    'defaults' => [
                        'controller' => 'Automovel\\V1\\Rest\\Automovel\\Controller',
                    ],
                ],
            ],
            'automovel.rest.usuario' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/usuario[/:usuario_id]',
                    'defaults' => [
                        'controller' => 'Automovel\\V1\\Rest\\Usuario\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'automovel.rest.automovel',
            1 => 'automovel.rest.usuario',
        ],
    ],
    'zf-rest' => [
        'Automovel\\V1\\Rest\\Automovel\\Controller' => [
            'listener' => \Automovel\V1\Rest\Automovel\AutomovelResource::class,
            'route_name' => 'automovel.rest.automovel',
            'route_identifier_name' => 'automovel_id',
            'collection_name' => 'automovel',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Automovel\V1\Rest\Automovel\AutomovelEntity::class,
            'collection_class' => \Automovel\V1\Rest\Automovel\AutomovelCollection::class,
            'service_name' => 'Automovel',
        ],
        'Automovel\\V1\\Rest\\Usuario\\Controller' => [
            'listener' => \Automovel\V1\Rest\Usuario\UsuarioResource::class,
            'route_name' => 'automovel.rest.usuario',
            'route_identifier_name' => 'usuario_id',
            'collection_name' => 'usuario',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Automovel\V1\Rest\Usuario\UsuarioEntity::class,
            'collection_class' => \Automovel\V1\Rest\Usuario\UsuarioCollection::class,
            'service_name' => 'Usuario',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Automovel\\V1\\Rest\\Automovel\\Controller' => 'HalJson',
            'Automovel\\V1\\Rest\\Usuario\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Automovel\\V1\\Rest\\Automovel\\Controller' => [
                0 => 'application/vnd.automovel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Automovel\\V1\\Rest\\Usuario\\Controller' => [
                0 => 'application/vnd.automovel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Automovel\\V1\\Rest\\Automovel\\Controller' => [
                0 => 'application/vnd.automovel.v1+json',
                1 => 'application/json',
                2 => 'application/x-www-form-urlencoded',
            ],
            'Automovel\\V1\\Rest\\Usuario\\Controller' => [
                0 => 'application/vnd.automovel.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Automovel\V1\Rest\Automovel\AutomovelEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'automovel.rest.automovel',
                'route_identifier_name' => 'automovel_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Automovel\V1\Rest\Automovel\AutomovelCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'automovel.rest.automovel',
                'route_identifier_name' => 'automovel_id',
                'is_collection' => true,
            ],
            \Automovel\V1\Rest\Usuario\UsuarioEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'automovel.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \Automovel\V1\Rest\Usuario\UsuarioCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'automovel.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'Automovel\\V1\\Rest\\Automovel\\Controller' => [
            'input_filter' => 'Automovel\\V1\\Rest\\Automovel\\Validator',
        ],
        'Automovel\\V1\\Rest\\Usuario\\Controller' => [
            'input_filter' => 'Automovel\\V1\\Rest\\Usuario\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Automovel\\V1\\Rest\\Automovel\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'message' => 'Entrar com o nome do automóvel',
                            'max' => '250',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'nome',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '2',
                            'max' => '2',
                            'message' => 'O estado deve ser informado como sigla, sendo duas letras',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringToUpper::class,
                        'options' => [],
                    ],
                ],
                'name' => 'uf',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'message' => 'Favor entrar com a cidade',
                            'max' => '250',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'cidade',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'descricao',
            ],
        ],
        'Automovel\\V1\\Rest\\Usuario\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [
                            'message' => 'Favor entrar com um e-mail válido',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'login',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '150',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'senha',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Automovel\\V1\\Rest\\Automovel\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
            'Automovel\\V1\\Rest\\Usuario\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [],
    ],
];
