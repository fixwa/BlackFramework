<?php namespace Application\Modules\News\Controllers;

use Application\Modules\News\Models\News;
use \Black\Container;

class HomeController extends Base
{
    public function init()
    {
        $this->newsModel = Container::get('entity', ['news', true]);
    }


    public function indexAction()
    {
        $articles = array();
    //    $articles['mainArticle']     = $newsModel->getForPlaceHolder('mainArticle');
    //    $articles['mainBannerRight'] = $newsModel->getForPlaceHolder('mainBannerRight');
        $articles['columnOne']       = $this->newsModel->getForPlaceHolder('columnOne');
        $articles['columnTwo']       = $this->newsModel->getForPlaceHolder('columnTwo');
        $articles['columnThree']     = $this->newsModel->getForPlaceHolder('columnThree');
        $articles['middleBottom']    = $this->newsModel->getForPlaceHolder('middleBottom');
        $articles['footer']          = $this->newsModel->getForPlaceHolder('footer');

        $this->view->articles = $articles;
    }
}
