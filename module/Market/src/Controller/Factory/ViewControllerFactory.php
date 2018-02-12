<?php

namespace Market\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Market\Controller\ViewController;

class ViewControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ViewController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ViewController();
    }
}
