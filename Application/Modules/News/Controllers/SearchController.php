<?php
namespace Application\Modules\News\Controllers;

class SearchController extends Base
{


    public function indexAction()
    {
        $phrase = $this->request->getParam('phrase');
        $phrase = str_replace('-', ' ', $phrase);
        $articles = $this->models->news->getForSearch($phrase);

        $this->view->articles = $articles;
        $this->view->phrase = $phrase;
    }

    public function searchPostAction()
    {
        $phrase = $this->request->getPostData('phrase');

        header('Location: /search/' . \Black\String::slugify($phrase));
    }
}
