<?php namespace Application\Modules\Admin\Controllers;

use \Black\Config;
use \Black\Redirector;

class UserController extends \Black\Controller
{
    public function loginAction()
    {
        $this->view->disable();
        Redirector::getInstance()
                ->toRoute('adminEntities')
                ->go();
    }
}
