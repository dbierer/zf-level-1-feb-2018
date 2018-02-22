<?php
namespace Model\Table\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Model\Table\ListingsTable;

class ListingsTableFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ListingsTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ListingsTable($container->get('model-primary-adapter'));
    }
}
