<?php namespace Application\Modules\User\Controllers;

use \Black\Redirector;
use \Black\Container;

class DashboardController extends \Black\Controller
{
    public function indexAction()
    {
        $this->view->selectedTab = 'dashboard';
    }
}
