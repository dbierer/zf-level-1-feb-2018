<?php

namespace Market\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Market\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new IndexController();
        $controller->setCategories($container->get('categories'));
	$controller->setAdapter($container->get('market-db-adapter'));
        return $controller;
    }
}
