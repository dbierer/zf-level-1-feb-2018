<?php
namespace Market\Controller;

use Model\Traits\ListingsTableTrait;
use Model\Interfaces\ListingsTableAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
class Base extends AbstractActionController implements ListingsTableAwareInterface
{
    use ListingsTableTrait;
}
