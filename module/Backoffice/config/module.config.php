<?php

namespace Backoffice;

use Backoffice\Controller\Factory\PostControllerFactory;
use Backoffice\Controller\IndexController;
use Backoffice\Controller\PostController;
use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin-root' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'posts' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/posts',
                            'defaults' => [
                                'controller' => PostController::class,
                                'action' => 'index'
                            ]
                        ],
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'db' => 'Zend\Db\Adapter\Adapter',
        ],
        'abstract_factories' => array(
        ),
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => InvokableFactory::class,
            PostController::class => PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/backoffice'           => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
