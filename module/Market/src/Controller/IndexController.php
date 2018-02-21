<?php
namespace Market\Controller;

use Market\Traits\ {CategoryTrait,AdapterTrait};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ {ViewModel,JsonModel};
use Zend\Db\Sql\ {Sql,Where};
class IndexController extends AbstractActionController
{
    use CategoryTrait;
    use AdapterTrait;
    const PDF_TARZAN = __DIR__ . '/../../../../data/pdf/tarzan_of_the_apes.pdf';

    public function indexAction() 
    {
	$list = $this->adapter->query('SELECT * FROM listings', []);
	$sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()->where('price < 100')->from('listings')->order('category');
	$statement = $sql->prepareStatementForSqlObject($select);
	$results = $statement->execute();
	// SELECT * FROM listings WHERE 
        $viewModel = new ViewModel(['categories' => $this->categories, 'list' => $results]);
	$viewModel->setTemplate('market/index/default');
	//$viewModel->setTerminal(TRUE);
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
    public function adapterAction()
    {
	$sql = new Sql($this->adapter);
        $select = $sql->select();
	$select->from('products')->where(
		(new Where())->greaterThanOrEqualTo('qty_oh', 10)
		             ->lessThan('cost', 100)
        );
	echo '<pre>';
	echo $select->getSqlString($this->adapter->getPlatform());
	echo '</pre>';
	return $this->getResponse();
    }
}
