<?php namespace Application\Modules\News\Controllers;

use Application\Modules\News\Models\News;

class HomeController extends Base
{


    public function indexAction()
    {
        $newsModel = \Black\Container::get('entities')->getModelFor('news')->create();

        //$allSections = $this->models->section->getAllFromConfig();
        $articles = array();
    //    $articles['mainArticle']     = $newsModel->getForPlaceHolder('mainArticle');
    //    $articles['mainBannerRight'] = $newsModel->getForPlaceHolder('mainBannerRight');
        $articles['columnOne']       = $newsModel->getForPlaceHolder('columnOne');
        $articles['columnTwo']       = $newsModel->getForPlaceHolder('columnTwo');
        $articles['columnThree']     = $newsModel->getForPlaceHolder('columnThree');
        $articles['middleBottom']    = $newsModel->getForPlaceHolder('middleBottom');
        $articles['footer']          = $newsModel->getForPlaceHolder('footer');

        $this->view->articles = $articles;
    }
}
