<?php

namespace Backoffice;

use Backoffice\Controller\Factory\PostControllerFactory;
use Backoffice\Controller\IndexController;
use Backoffice\Controller\PostController;
use Backoffice\Service\Command\Handler\CreatePostHandler;
use Backoffice\Service\Command\Handler\Factory\CreatePostHandlerFactory;
use Zend\Router\Http\Literal;

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
        'factories' => [
            CreatePostHandler::class => CreatePostHandlerFactory::class,
        ]
    ],
    'controllers' => [
        'invokables' => [
            IndexController::class => IndexController::class,
        ],
        'factories' => [
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
