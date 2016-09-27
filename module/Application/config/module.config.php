<?php

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Infrastructure\Finder\Factory\FinderAbstractFactory;
use Application\Infrastructure\Mapper\MapperInterface;
use Application\Infrastructure\Mapper\PostMapper;
use Application\Infrastructure\Repository\Factory\RepositoryAbstractFactory;
use Application\Infrastructure\Service\Factory\TransactionManagerFactory;
use Application\Infrastructure\Service\TransactionManager;
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
                'may_terminate' => true,
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => ':slug',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'show',
                            ],
                            'constraints' => [
                                'slug' => '[0-9a-z-]+'
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
            FinderAbstractFactory::class,
            RepositoryAbstractFactory::class,
        ),
        'invokables' => [
            MapperInterface::class => PostMapper::class
        ],
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',

            TransactionManager::class => TransactionManagerFactory::class,

            // Service
            PostService::class => PostServiceFactory::class,

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
