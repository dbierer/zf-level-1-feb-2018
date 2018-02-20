<?php
namespace Market\Form\Factory;
use Market\Form\PostFilter;
use Interop\Container\ContainerInterface;
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use Zend\ServiceManager\Factory\FactoryInterface;
class PostFilterFactory implements FactoryInterface 
{
    public function __invoke(ContainerInterface $container, $requestedName,array $options = null) {
        try {
            $filter = new PostFilter($container->get('categories'),$container->get('expire-days'));
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            //Handle
        }
        return $filter;
    }
}
