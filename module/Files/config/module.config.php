<?php 
namespace Files;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
	'service_manager' => [
        'aliases' => [
            Model\FilesRepositoryInterface::class => Model\LaminasDbSqlRepository::class,
            Model\FilesCommandInterface::class => Model\FilesCommand::class,
        ],
        'factories' => [
            Model\FilesRepository::class => InvokableFactory::class,
            Model\LaminasDbSqlRepository::class => Factory\LaminasDbSqlRepositoryFactory::class,
            Model\FilesCommand::class => Factory\FilesCommandFactory::class,
        ],
    ],

	'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class,
            Controller\WriteController::class => Factory\WriteControllerFactory::class,
        ],
    ],

    // This lines opens the configuration for the RouteManager
    'router' => [
        // Open configuration for all possible routes
        'routes' => [
            // Define a new route called "files"
            'files' => [
                // Define a "literal" route type:
                'type' => Segment::class,
                // Configure the route itself
                'options' => [
                    // Listen to "/files" as uri:
                    'route' => '/files',
                    // Define default controller and action to be called when
                    // this route is matched
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                    ],
                ],                
                'may_terminate' => true,
                'child_routes'  => [
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],

                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                            	'controller' => Controller\WriteController::class,
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],

                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/delete/:id',
                            'defaults' => [
                            	'controller' => Controller\WriteController::class,
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],

                    'add' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'add',
                            ],
                        ],
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
];