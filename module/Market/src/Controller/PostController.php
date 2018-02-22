<?php
namespace Market\Controller;

use Market\Form\PostForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends Base
{
    protected $postForm;
    public function indexAction()
    {
        $data = [];
        $message = '';
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                if ($this->listingsTable->save($this->postForm->getData())) {
                    $this->flashMessenger()->add('<h1 style="color:green;">SUCCESS ... New Item Added!</h1>');
                    return $this->redirect()->toRoute('market');
            } else {
                $message = '<h1 style="color:red;">SORRY ... You Are Out!</h1>';
            }
        }
        return new ViewModel(['postForm' => $this->postForm, 'message' => $message]);
    }    
    public function setPostForm(PostForm $form) 
    {  
        $this->postForm = $form;
    }
}
