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
                                'action'     => 'index',
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
    'view_manager' => [
	'template_map' => [
	    'market/index/default' => __DIR__ . '/../view/market/index/not_the_default.phtml',
	],
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
];
