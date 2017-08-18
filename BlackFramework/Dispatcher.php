<?php namespace Black;

use \Black\Exceptions\RouteNotFoundException;
use \Black\Exceptions\ControllerNotFoundException;

class Dispatcher
{
    public $match;
    public $module;
    public $namespace;
    public $controllerName;
    public $controllerClass;
    public $controllerObject;


    public function __construct($router)
    {
        $this->router = $router;
    }


    public function dispatch()
    {
        $this->match = $this->router->match();

        if ($this->match === false) {
            throw new RouteNotFoundException('No route for this url.');
        }

        if ($this->match['name'] === 'default') {
            $this->match['target']['module'] = ucfirst($this->match['params']['module']);
            $this->match['target']['controller'] = ucfirst($this->match['params']['controller']) . 'Controller';
            $this->match['target']['action'] = ucfirst($this->match['params']['action']);
        }

        $this->match['target']['params'] = $this->match['params'];
        $this->match['target']['method'] = $this->match['method'];
        $this->match['target']['name'] = $this->match['name'];

        $this->module           = $this->match['target']['module'];
        $this->controllerAction = $this->match['target']['action'];
        $this->namespace        = '\\Application\\Modules\\' . $this->module . '\\Controllers';
        $this->controllerName   =  $this->match['target']['controller'];
        $this->controllerClass  = $this->namespace . '\\' . $this->controllerName;

        Container::set('controller', function () {
            if (!class_exists($this->controllerClass)) {
                throw new ControllerNotFoundException('Controller not found: ' . $this->controllerClass);
            }
            $this->controllerObject = new $this->controllerClass();

            if (method_exists($this->controllerObject, 'init')) {
                $this->controllerObject->init();
            }

            if (method_exists($this->controllerObject, $this->match['target']['action'])) {
                $param = null;
                if (!empty($this->match['target']['params']) && (count($this->match['target']['params']) === 1)) {
                    $param = preg_replace("/[^a-zA-Z0-9]+/", '', current($this->match['target']['params']));
                }
                $this->controllerObject->{$this->match['target']['action']}($param);
            }

            if (method_exists($this->controllerObject, 'postDispatch')) {
                $this->controllerObject->postDispatch();
            }

            return $this->controllerObject;
        });

        //Update the dispatcher in the container.
        $instance = $this;
        Container::update('dispatcher', function () use ($instance) {
            return $instance;
        });
    }
}
