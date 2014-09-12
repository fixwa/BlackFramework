<?php namespace Black\View;

use \Black\Container;

class Module
{
    private static $instance = null;
    public static $allModules = [];

    private function __construct()
    {
        $modulesModel = Container::get('entity', ['module', true]);
        self::$allModules = $modulesModel->getAllActive();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }



    public function get($placeHolder)
    {
        $allFiltered = [];
        foreach (self::$allModules as $module) {
            if (!empty($module->placeholders)) {
                $placeholders = explode(',', $module->placeholders);
                if (in_array($placeHolder, $placeholders)) {
                    $allFiltered[] = $module;
                }
            }
        }

        $ret = '';
        foreach ($allFiltered as $key => $module) {
            $ret .= $module->html . PHP_EOL;
        }
        return $ret;
    }
}
