<?php
namespace Import\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Import\Service\FileManager;
use Import\Controller\FileController;

/**
 * This is the factory for ImageController. Its purpose is to instantiate the
 * controller.
 */
class FileControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $fileManager = $container->get(FileManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Instantiate the controller and inject dependencies
        return new FileController($fileManager,$authService,$entityManager);
    }
}

