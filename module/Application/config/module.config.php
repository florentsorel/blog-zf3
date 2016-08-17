<?php

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Infrastructure\Finder\Factory\PostFinderFactory;
use Application\Infrastructure\Finder\Factory\TagFinderFactory;
use Application\Infrastructure\Finder\PostFinder;
use Application\Infrastructure\Finder\TagFinder;
use Application\Service\Factory\PostServiceFactory;
use Application\Service\PostService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'root' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'post' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/:slug',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'show',
                    ],
                    'constraints' => [
                        'slug' => '[0-9a-z-]+'
                    ]
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'db' => 'Zend\Db\Adapter\Adapter',
        ],
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            /// Service
            PostService::class => PostServiceFactory::class,
            // Finder
            PostFinder::class => PostFinderFactory::class,
            TagFinder::class => TagFinderFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
