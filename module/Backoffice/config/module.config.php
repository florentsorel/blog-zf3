<?php

namespace Backoffice;

use Backoffice\Command\Handler\CreatePostHandler;
use Backoffice\Command\Handler\Factory\CreatePostHandlerFactory;
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
                        'may_terminate' => true,
                        'child_routes' => [
                            'create' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route'    => '/create',
                                    'defaults' => [
                                        'controller' => PostController::class,
                                        'action' => 'create'
                                    ]
                                ],
                            ],
                        ]
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [

    ],
    'controllers' => [
        'factories' => [
            IndexController::class => InvokableFactory::class,
            PostController::class => PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'layout/backoffice'           => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
