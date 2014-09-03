<?php namespace Application\Modules\Main\Controllers;

class HomeController extends \Black\Controller
{
    public function indexAction()
    {
        $this->view->txt = 'todo ok';
    }
}
