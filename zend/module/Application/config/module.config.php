<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use src\Util\Http;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'swagger' => [
        'paths' => [
            __DIR__ . '/../src'
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/application',
                    'constraints' => [
                        'id' => '[a-zA-Z0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                    ],
                ],
                "may_terminate" => true,
                "child_routes" => [
                    "api" => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/api[/:id]',
                            'constraints' => [
                                'id' => '[a-zA-Z0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\IndexRestController::class,
                            ],
                        ]
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexFactory::class,
            Controller\IndexRestController::class => Controller\Factory\IndexRestFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            "http" => function () {
                $url = new Http();
                return $url;
            }
        ]
    ],
    'doctrine' => [
        'driver' => [
            str_replace('\\', '_', __NAMESPACE__) . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => str_replace('\\', '_', __NAMESPACE__) . '_driver'
                ]
            ]
        ],
        'fixtures' => [
            __NAMESPACE__ . 'Fixture' => __DIR__ . '/../src/Fixture'
        ]
    ]


];
