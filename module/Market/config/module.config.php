<?php
namespace Market;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'index' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/main[/:action]',
                         ],
                    ],
                    'view' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/view',
                            'defaults' => [
                                'controller' => Controller\ViewController::class,
                                'action' => 'index',
                                'category' => 'free',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/item[/:itemId]',
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'item',
                                    ],
                                ],
                            ],
                            'category' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/category[/:category]',
                                    'constraints' => [
                                        'category' => '[a-z]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/post',
                            'defaults' => [
                                'controller' => Controller\PostController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ViewController::class => Controller\Factory\ViewControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\PostForm::class => Form\Factory\PostFormFactory::class,
            Form\PostFilter::class => Form\Factory\PostFilterFactory::class,
        ],
	'services' => [
	    'market-db-config' => [
		'driver' => 'PDO',
		'dsn'	 => 'mysql:host=localhost;dbname=onlinemarket',
		'username' => 'vagrant',
		'password' => 'vagrant',
		'driver_options' => [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION],
	    ],
	],
    ],
    'view_manager' => [
	//'template_map' => [
	//    'market/index/default' => __DIR__ . '/../view/market/index/not_the_default.phtml',
	//],
        'template_path_stack' => [__DIR__ . '/../view'],
	'strategies' => ['ViewJsonStrategy'],
    ],
    'controller_plugins' => [
	'aliases' => [
	    'ninetyDays' => Plugins\NinetyDays::class,
            'dayWeekMonth' => Plugins\DayWeekMonth::class,
	],
	'factories' => [
	    Plugins\NinetyDays::class => InvokableFactory::class,
	    Plugins\DayWeekMonth::class => InvokableFactory::class,
	],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\LeftLinks::class => InvokableFactory::class
        ],
        'aliases' => [
            'leftLinks' => Helper\LeftLinks::class
        ],
    ],
];
