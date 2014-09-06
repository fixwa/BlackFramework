<?php namespace Black;

class Database extends \ORM
{
    public static function init($config)
    {
        parent::configure('mysql:host=' . $config->host . ';dbname=' . $config->databaseName);
        parent::configure('username', $config->user);
        parent::configure('password', $config->password);
        parent::configure('driver_options', [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);

        parent::configure('error_mode', \PDO::ERRMODE_WARNING);
        parent::configure('logging', isset($config->logging) ? $config->logging : false);
        parent::configure('logger', function ($log_string, $query_time) {
            /*
            $user = \Black\Session::get('user');
            $uniqueId = (!empty($user->uniqueId)) ? $user->uniqueId : 'guest';

            $logFile = \Black\Config\Config::$paths->application . '/Logs/queries.log';
            $handler = fopen($logFile, 'a') or exit("Can't open {$logFile}!");
            $time = date('d/M/Y:H:i:s');
            $logTxt = $log_string . ' in ' . $query_time;

            fwrite($handler, "[{$time}] [{$uniqueId}] {$logTxt}" . PHP_EOL);

            fclose($handler);
            */
        });
    }
}
