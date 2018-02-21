<?php
namespace Market;

use Zend\Db\Adapter\Adapter;
class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
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
