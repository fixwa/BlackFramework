<?php
namespace Application\Modules\News\Models;

class News extends \Black\Models\EntityModel
{
    // public static $_table = 'news';
    // public static $_id_column = 'id';
    public static $all = [];

    public function __construct()
    {

    }

    public function getAllActive()
    {
        if (empty(self::$all)) {
            self::$all = $this->orm
                ->where('enabled', '1')
                ->orderByDesc('id')
                ->orderByAsc('placeholder')
                ->limit(30)
                ->findMany();
        }
        return self::$all;
    }

    public function getForPlaceHolder($placeHolder, $limit = null)
    {
        $all = $this->getAllActive();

        $allFiltered = [];
        foreach ($all as $article) {
            if ($article->placeholder == $placeHolder) {
                $allFiltered[] = $article;
            }

        }
        return $allFiltered;
    }


    public function getForSearch($phrase)
    {

    }

    public function getImage($size = 'large')
    {
        return '/Assets/Uploads/' . $this->image;
    }
}
