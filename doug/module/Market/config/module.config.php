<?php
namespace Market;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'market' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/market[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'controller_plugins' => [
	'aliases' => [
	    'ninetyDays' => Plugins\NinetyDays::class,
	],
	'factories' => [
	    Plugins\NinetyDays::class => InvokableFactory::class,
	],
    ],
];
