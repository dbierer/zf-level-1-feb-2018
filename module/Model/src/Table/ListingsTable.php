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
    }
    public function findById(int $id)
    {
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
    public function save()
    {
    }
    public function getDateExpires(int $expires)
    {
    }
}
