<?php
namespace Search;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
return [

    'router' => [
        'routes' => [
            'search' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/szukaj[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\SearchController::class,
                        'action'     => 'index',

                        //Autoryzacja do API
                        'isAuthorizationRequired' => false
                    ],
                ],
            ],
        ],
    ],

   'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\SearchController::class =>  Controller\Factory\SearchControllerFactory::class,
        ],
    ],
    'service_manager' => [
        // ...
        'factories' => [
            // Register the FileManager service
            Service\SearchManager::class => InvokableFactory::class,
            Service\SearchManager::class => Service\Factory\SearchManagerFactory::class,

        ],
    ],


];
