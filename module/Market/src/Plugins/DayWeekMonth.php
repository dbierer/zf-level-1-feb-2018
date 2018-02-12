<?php
namespace Market\Plugins;

use DateTime;
use DateInterval;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DayWeekMonth extends AbstractPlugin 
{
    public function __invoke($date = NULL) 
    { 
        if (!$date) {
            $date = new DateTime();
        }
        $output = ['today' => $date->format('l, d M Y')];
        $seed = ['tomorrow' => 'P1D', 'week' => 'P1W', 'month' => 'P1M'];
        foreach ($seed as $key => $value) {
            $newDate = clone $date;
            $output[$key] = $newDate->add(new DateInterval($value))->format('l, d M Y');
        }
        return $output;
    }
}
