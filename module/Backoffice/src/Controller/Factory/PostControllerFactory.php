<?php

namespace Backoffice\Controller\Factory;

use Application\Service\PostService;
use Backoffice\Controller\PostController;
use Backoffice\Service\Command\Handler\CreatePostHandler;
use Backoffice\Service\Command\Handler\UpdatePostHandler;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostControllerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostController(
            $container->get(PostService::class),
            $container->get(CreatePostHandler::class),
            $container->get(UpdatePostHandler::class)
        );
    }
}