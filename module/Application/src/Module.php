<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\IndexController;
use Zend\Mvc\MvcEvent;
class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $evm = $e->getApplication()->getEventManager();
	$shared = $evm->getSharedManager();
        $shared->attach(IndexController::class, 'custom-event', [$this, 'onTest'], 99);
        $evm->trigger('custom-event', $this);
    }
    
    public function onTest($e)
    {
        error_log('Event Class: ' . get_class($e) . ': Triggering Class: ' . get_class($e->getTarget()));
    }
}
