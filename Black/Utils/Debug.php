<?php namespace Black\Utils;

use \Black\Config;

class Debug
{
    public function showInfo()
    {
        $allNames = \Black\Container::getAllNames();

        echo '<pre style="border-top: 1px solid #FFC75E; padding: 4px; font-size: 11px;">';
        echo 'Container' .PHP_EOL.PHP_EOL;
        print_r($allNames);
        echo '</pre>';

        echo '<pre style="border-top: 1px solid #FFC75E; padding: 4px; font-size: 11px;">';
        echo 'Config - Paths' .PHP_EOL.PHP_EOL;
        print_r(Config::$paths);
        echo 'Config - Configs' .PHP_EOL.PHP_EOL;
        print_r(Config::$configs);
        echo '</pre>';

    }
}
