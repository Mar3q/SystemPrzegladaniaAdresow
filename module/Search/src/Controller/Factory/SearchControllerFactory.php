<?php
namespace Search\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Search\Service\SearchManager;
use Search\Controller\SearchController;


class SearchControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $searchManager = $container->get(SearchManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Instantiate the controller and inject dependencies
        return new SearchController($searchManager,$authService,$entityManager);
    }
}

