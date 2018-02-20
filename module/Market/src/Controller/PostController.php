<?php
namespace Market\Controller;

use Market\Form\PostForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
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
                $message = '<h1 style="color:green;">SUCCESS ... You Are In!</h1>';
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
