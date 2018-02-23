<?php
namespace Market\Controller;

use Market\Traits\ {CategoryTrait,AdapterTrait};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ {ViewModel,JsonModel};
use Zend\Db\Sql\ {Sql,Select,Where,Expression,Literal};
class IndexController extends Base
{
    use CategoryTrait;
    use AdapterTrait;
    const PDF_TARZAN = __DIR__ . '/../../../../data/pdf/tarzan_of_the_apes.pdf';

    public function indexAction() 
    {
        $viewModel = new ViewModel(['item' => $this->listingsTable->findLatest(), 'messages' => $this->flashMessenger()->getMessages()]);
        return $viewModel;
    }
    public function dayWeekMonthAction() {
        return new ViewModel($this->dayWeekMonth());
    }
    public function loginAction()
    {
        $userLoggedIn = $this->params()->fromQuery('isLoggedIn', 0);
        if (!$userLoggedIn) {
            return $this->redirect()->toRoute('home');
        }        
        return new ViewModel($this->dayWeekMonth());
    }
    public function testAction()
    {
	$heading = $this->params()->fromQuery('heading','Default');
	$goHome  = $this->params()->fromQuery('gohome', FALSE);
	if ($goHome) {
	    // prefixing a command to "return" interrupts the controller action
	    return $this->redirect()->toRoute('home');
	    // now this code will not be executed:
	    echo "<br>Why is this showing up???";
	    sleep(5);
        }
        return new ViewModel(['heading' => $heading]);
    }
    // example of bypassing the layout:
    public function ninetyAction()
    {
        $viewModel = new ViewModel(['ninety' => $this->ninetyDays()]);
	$viewModel->setTerminal(TRUE);
	return $viewModel;
    }
    public function ninetyJsonAction()
    {
        $jsonModel = new JsonModel(['today' => date('l, d M Y'), 'ninety' => $this->ninetyDays()]);
	return $jsonModel;
    }
    public function pdfAction()
    {
	$response = $this->getResponse();
	$response->getHeaders()->addHeaderLine('Content-Type', 'application/pdf');
	// we will assume at this point we're getting the contents of a PDF file
	$contents = file_get_contents(self::PDF_TARZAN);
	$response->setBody($contents);
	return $response;
    }
    /*
     * NOTE: the examples here assume you have these database tables:
     *
    CREATE TABLE `event` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) DEFAULT '',
      `max_attendees` int(11) DEFAULT NULL,
      `date` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
     *
    CREATE TABLE `registration` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `event_id` int(11) NOT NULL,
      `first_name` varchar(255) NOT NULL,
      `last_name` varchar(255) NOT NULL,
      `registration_time` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
     */
    public function adapterAction()
    {

        // hard coded SQL example:
        $sql     = 'SELECT e.name, r.registration_time, '
                 . 'CONCAT(r.first_name, \' \', r.last_name) AS full_name '
                 . 'FROM event AS e '
                 . 'JOIN registration AS r ON e.id = r.event_id '
                 . 'WHERE r.first_name LIKE :name '
                 . 'ORDER BY e.id, r.registration_time';
        $results = $this->adapter->query($sql, ['name' => 'D%']);
        echo '<pre>' . var_dump($results->toArray()) . '</pre>';

        // using "createStatement()"
        $results = [];
        $sql = 'SELECT e.name, r.registration_time, '
             . 'CONCAT(r.first_name, \' \', r.last_name) AS full_name '
             . 'FROM event AS e '
             . 'JOIN registration AS r ON e.id = r.event_id '
             . 'WHERE r.first_name LIKE ? '
             . 'ORDER BY e.id, r.registration_time';
        $statement = $this->adapter->createStatement($sql);
        $results   = $statement->execute(['D%']);
        echo '<pre>' . var_dump(iterator_to_array($results)) . '</pre>';

        // using Zend\Db\Sql
        $zdbSql = new Sql($this->adapter);
        $concat = new Expression("CONCAT(r.first_name,' ',r.last_name)");
        $where  = new Where();
        $where->greaterThanOrEqualTo('r.registration_time', '2017')
              ->and->nest()->like('r.first_name', 'D%')->or->like('r.first_name', 'S%')->unnest();
        $select = $zdbSql->select();
        $select->from(['e' => 'event'])
               ->columns(['name']) 
               ->join(['r' => 'registration'],
                       'e.id = r.event_id',
                       ['registration_time', 'fullName' => $concat],
                       Select::JOIN_INNER)
               ->where($where)
               ->order('e.id ASC, r.registration_time ASC');
        echo $select->getSqlString($this->adapter->getPlatform());
        $result = $zdbSql->prepareStatementForSqlObject($select)->execute();
        echo '<pre>' . var_dump(iterator_to_array($result)) . '</pre>'; 
        // bail out
	return $this->getResponse();
    }
}
