<?php
namespace Application\Modules\News\Controllers;

class ArticleController extends Base
{


    public function indexAction()
    {
        $articleId = $this->request->getParam('articleId');

        $article = $this->models->news->getById($articleId);
        $this->view->article = $article;

        $sectionModel = new \Application\Modules\News\Models\Section();

        $moreArticles = array();
        $moreArticles['sameSection'] = $sectionModel->getForSection(
            $article->section,
            $articleId,
            3
        );
        $this->view->moreArticles = $moreArticles;

    }
}
