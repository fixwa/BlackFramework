<?php namespace Application\Modules\Admin\Controllers;

use \Black\Config;

class HomeController extends \Black\Controller
{

    public function indexAction()
    {
        $this->view->layout = Config::$paths['application'] . '/Modules/Admin/Views/Layouts/simple.phtml';
        $this->view->styles[] = '/Assets/css/admin.signin.css';

        //$entites = \Black\Entity\Manager::getAll();
        //his->view->entitesMenu = $entites;
    }
}
