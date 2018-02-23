<?php
namespace Model\Table;
use DateTime;
use DateInterval;
use Zend\Db\{Adapter\Adapter, Sql\Sql, TableGateway\TableGateway};
class ListingsTable extends TableGateway 
{
    const TABLE_NAME = 'listings';
    public function __construct(Adapter $adapter)
    {
        parent::__construct(self::TABLE_NAME,$adapter);
    }
    public function findByCategory(string $category)
    {
        return $this->select(['category' => $category]);
    }
    public function findById(int $id)
    {
        return $this->select(['listings_id' => $id])->current();
    }
    public function findLatest()
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id DESC')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
    public function save($data)
    {
	$data = array_merge($data, $this->splitCityCode($data['cityCode']));
	$data['date_expires'] = $this->getDateExpires($data['expires']);
	unset($data['cityCode']);
	unset($data['expires']);
	unset($data['captcha']);
	unset($data['submit']);
	return $this->insert($data);
    }
    public function getDateExpires(int $expires)
    {
	$date = new DateTime();
        $interval = '';
	switch ($expires) {
	    case 1 :
		$interval = 'P1D';
		break;	
	    case 7 :
		$interval = 'P1W';
		break;	
	    case 30 :
		$interval = 'P1M';
		break;
	    case 0 :
	    default :
		$interval = '';
	}
	if (!$interval) {
	    return NULL;
	} else {
	    $date->add(new DateInterval($interval));
	    return $date->format('Y-m-d');
	}
    }
    public function splitCityCode($cityCode)
    {
	list($city,$country) = explode(',', $cityCode);
	return ['city' => $city, 'country' => $country];
    }
}
