<?php namespace Black\Models;

use \Black\Exceptions\EntityValidationException;

class ViewModule extends \Black\Models\EntityModel
{
    public static $_table = 'modules';
    public static $all = [];

    public function getAllActive()
    {
        if (empty(self::$all)) {
            self::$all = $this->orm
                ->where('enabled', '1')
                ->orderByDesc('id')
                ->orderByAsc('placeholders')
                ->limit(30)
                ->findMany();
        }
        return self::$all;
    }
}
