<?php

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\Factory\UserControllerFactory;
use Application\Controller\IndexController;
use Application\Controller\UserController;
use Application\Infrastructure\Finder\Factory\FinderAbstractFactory;
use Application\Infrastructure\Mapper\PostMapper;
use Application\Infrastructure\Mapper\UserMapper;
use Application\Infrastructure\Repository\Factory\PostRepositoryFactory;
use Application\Infrastructure\Repository\Factory\UserRepositoryFactory;
use Application\Infrastructure\Repository\PostRepository;
use Application\Infrastructure\Repository\UserRepository;
use Application\Infrastructure\Service\Factory\TransactionManagerFactory;
use Application\Infrastructure\Service\TransactionManager;
use Application\Service\Command\Handler\CreateUserHandler;
use Application\Service\Command\Handler\Factory\CreateUserHandlerFactory;
use Application\Service\Factory\PostServiceFactory;
use Application\Service\PostService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

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
                            'route'    => 'article/:slug',
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
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'register' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/register',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action' => 'register',
                    ],
                ],
            ],


        ],
    ],
    'service_manager' => [
        'aliases' => [
            'db' => 'Zend\Db\Adapter\Adapter',
        ],
        'abstract_factories' => array(
            FinderAbstractFactory::class,
        ),
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            TransactionManager::class => TransactionManagerFactory::class,

            // Service
            PostService::class => PostServiceFactory::class,

            // Repository
            PostRepository::class => PostRepositoryFactory::class,
            UserRepository::class => UserRepositoryFactory::class,

            // Mapper
            PostMapper::class => InvokableFactory::class,
            UserMapper::class => InvokableFactory::class,

            // Handler
            CreateUserHandler::class => CreateUserHandlerFactory::class,

        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
            UserController::class => UserControllerFactory::class,
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
