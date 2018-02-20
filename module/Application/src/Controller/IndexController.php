<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
	// get controller event manager
	$evm1 = $this->getEventManager();
        $evm1->trigger('custom-event', $this);
	// get MVC event manager
	$evm2 = $this->getEvent()->getApplication()->getEventManager();
        $evm2->trigger('custom-event', $this);
        return new ViewModel();
    }
}
