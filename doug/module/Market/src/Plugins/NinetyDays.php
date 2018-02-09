<?php
namespace Market\Plugins;

use DateTime;
use DateInterval;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class NinetyDays extends AbstractPlugin 
{
    public function __invoke($date = NULL) 
    {
        if (!$date) {
	    $date = new DateTime();
	}
	$date->add(new DateInterval('P90D'));
	return $date->format('l, d M Y');
    }
}
