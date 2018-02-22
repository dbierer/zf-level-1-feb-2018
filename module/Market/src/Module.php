<?php
namespace Market;

use Model\Interfaces\ListingsTableAwareInterface;
use Zend\Db\Adapter\Adapter;
class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'initializers' => [
                'market-inject-listings-table' => function ($container, $instance) {
                    if ($instance instanceof ListingsTableAwareInterface) {
                        $instance->setListingsTable($container->get('model-listings-table'));
                    }
                },
             ],
        ];
    }
    public function getServiceConfig()
    {
	return [
	    'factories' => [
		'market-db-adapter' => function ($container) {
		    return new Adapter($container->get('market-db-config'));
		},
	    ],
	];
    }	

}
