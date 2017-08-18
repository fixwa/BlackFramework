<?php
namespace Black\Services;

use \Black\Container;
use \Black\Config;
use \Black\Router;
use \Black\Dispatcher;
use \Black\View;
use \Black\Session;
use \Black\Utils\Debug;
use \Black\View\Translation;
use \Black\Entity\Provider;

class Core
{
    public static function init()
    {
        //Initialize the transaltor. //@todo Add language-detection logic.
        Translation::setMessageLibrary(
            Config::$paths['application'] . '/Languages/es.php'
        );

        Container::setSingleInstance('user', function () {
            //$user = include Config::$paths['routes'] . '/ApplicationRoutes.php';
            //return new Router($user);
        });

        Container::setSingleInstance('router', function () {
            $routes = include Config::$paths['routes'] . '/ApplicationRoutes.php';
            return new Router($routes);
        });

        Container::setSingleInstance('dispatcher', function () {
            $router = Container::get('router');
            $dispatcher = new Dispatcher($router);
            return $dispatcher;
        });

        Container::setSingleInstance('view', function () {
            $view = new View();
            return $view;
        });

        Container::setSingleInstance('debug', function () {
            $debug = new Debug();
            return $debug;
        });

        Container::setSingleInstance('db', function () {
            $config = Config::get('application');
            $database = \Black\Database::init($config->database);
            return $database;
        });

        Container::setSingleInstance('entities', function () {
            Container::get('db');
            $entities = Config::get('entities');
            $provider = new \Black\Entity\Provider($entities);
            return $provider->init();
        });

        Container::set('entity', function ($entityName) {
            $create = false;
            if (is_array($entityName)) {
                $entityName = $entityName[0];
                $create = $entityName[1];
            }
            $model = Container::get('entities')->getModelFor(strtolower($entityName), $create);
            return $model;
        });

        //@todo Add cookie check into the container.
        Container::setSingleInstance('userSession', function () {
            if (Session::isRegistered('user')) {
                $user = Session::get('user');
            } else {
                $user = new \stdClass;
                $user->ip = \Black\Request::getIp();
                $user->uniqueId = uniqid('[guest]');
                $user->isAdmin = false;
                $user->isLoggedIn = false;
            }
            return $user;
        });

        Container::setSingleInstance('lang', function () {

        });
    }
}
