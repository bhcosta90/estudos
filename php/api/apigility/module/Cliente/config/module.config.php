<?php
return [
    'service_manager' => [
        'factories' => [
            \Cliente\V1\Rest\Cliente\ClienteResource::class => \Cliente\V1\Rest\Cliente\ClienteResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'cliente.rest.cliente' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/cliente[/:cliente_id]',
                    'defaults' => [
                        'controller' => 'Cliente\\V1\\Rest\\Cliente\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'cliente.rest.cliente',
        ],
    ],
    'zf-rest' => [
        'Cliente\\V1\\Rest\\Cliente\\Controller' => [
            'listener' => \Cliente\V1\Rest\Cliente\ClienteResource::class,
            'route_name' => 'cliente.rest.cliente',
            'route_identifier_name' => 'cliente_id',
            'collection_name' => 'cliente',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Cliente\V1\Rest\Cliente\ClienteEntity::class,
            'collection_class' => \Cliente\V1\Rest\Cliente\ClienteCollection::class,
            'service_name' => 'Cliente',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Cliente\\V1\\Rest\\Cliente\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Cliente\\V1\\Rest\\Cliente\\Controller' => [
                0 => 'application/vnd.cliente.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'application/x-www-form-urlencoded',
            ],
        ],
        'content_type_whitelist' => [
            'Cliente\\V1\\Rest\\Cliente\\Controller' => [
                0 => 'application/vnd.cliente.v1+json',
                1 => 'application/json',
                2 => 'application/x-www-form-urlencoded',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Cliente\V1\Rest\Cliente\ClienteEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cliente.rest.cliente',
                'route_identifier_name' => 'cliente_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Cliente\V1\Rest\Cliente\ClienteCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cliente.rest.cliente',
                'route_identifier_name' => 'cliente_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'Cliente\\V1\\Rest\\Cliente\\Controller' => [
            'input_filter' => 'Cliente\\V1\\Rest\\Cliente\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Cliente\\V1\\Rest\\Cliente\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '250',
                            'message' => 'No máximo 250 letras',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'nome',
            ],
        ],
    ],
];
