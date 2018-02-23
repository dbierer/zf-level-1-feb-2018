<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends Base
{
    public function indexAction()
    {
        $category = $this->params()->fromRoute('category');
        $list = $this->listingsTable->findByCategory($category);
        //echo __METHOD__ . ':<pre>' . var_export($list, TRUE) . '</pre>'; exit;
        return new ViewModel(['category' => $category, 'listing' => $list]);
    }
    public function itemAction() 
    {
        $itemId = $this->params()->fromRoute('itemId');
        $item = $this->listingsTable->findById($itemId);
        return new ViewModel(['item' => $item]);
    }
}
