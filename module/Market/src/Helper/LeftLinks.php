<?php
namespace Market\Helper;
use Zend\View\Helper\AbstractHtmlElement;
class LeftLinks extends AbstractHtmlElement 
{
    const ERROR_CATEGORIES = 'ERROR: no categories defined';
    public function __invoke(?array $values, $urlPrefix) 
    {
        if (empty($values)) return self::ERROR_CATEGORIES;
        $output = '<ul>';
        foreach ($values as $key => $value) {
            if (ctype_alpha($key)) {
                $attrib = $key;
            } else {
                $attrib = $value;
            }
            $output .= '<li><a href="' . $urlPrefix . $attrib . '">' . $value . '</a></li>' . PHP_EOL;
        }
        $output .= '</ul>' . PHP_EOL;
        return $output; 
    }
}
