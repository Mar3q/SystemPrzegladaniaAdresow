<?php
namespace Import;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
return [

    // This lines opens the configuration for the RouteManager
    'router' => [
        'routes' => [
            'files' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/files[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\FileController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\FileController::class =>
                Controller\Factory\FileControllerFactory::class,

            //...
        ],
    ],


    'service_manager' => [
        // ...
        'factories' => [
            // Register the FileManager service
            Service\FileManager::class => InvokableFactory::class,
            Service\FileManager::class => Service\Factory\FileManagerFactory::class,

        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]


];
