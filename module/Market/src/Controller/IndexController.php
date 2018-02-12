<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    const PDF_TARZAN = __DIR__ . '/../../../../data/pdf/tarzan_of_the_apes.pdf';

    public function indexAction()
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
    public function ninetyAction()
    {
        return new ViewModel(['ninety' => $this->ninetyDays()]);
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
}
