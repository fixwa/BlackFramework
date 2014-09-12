<?php namespace Black\View;

use \Black\Config;
use \Black\Container;
use \Black\View\Translation;
use \Black\View\Module;

class ViewHelper extends \Black\View
{

    protected $view;
    protected $config;

    public function __construct(\Black\View $view)
    {
        $this->view = $view;
        $this->config = $config = Config::get('application');
    }

    public function callMethod($name, $arguments)
    {
        $classInDefaultModule = '\\Application' . str_ireplace('/', '\\', $this->config->defaults->viewHelpers) .
            '\\' . ucfirst($name);

        if (method_exists($this, $name)) {
            return $this->{$name}(current($arguments));
        } elseif (class_exists($classInDefaultModule)) {
            $class = new $classInDefaultModule();
            return $class->init();
            //return call_user_func_array(array($this->helpers['moduleHelper'], 'init'), $arguments);
        }

        //$this->helpers['moduleHelper'] = new \Black\View\Helpers\Module($this);

    }

    /**
     * Attempts to load a 'partial' view from several paths.
     */
    public function partial($partialName)
    {
        //Try in current module
        $fileName = $this->view->moduleViewsFolder . '/_partials/' . $partialName;

        if (!realpath($fileName)) {
            //Try in default `path` (in config)
            $fileName = Config::$paths['application'] . '/' . $this->config->defaults->viewPartials .
                '/' . $partialName;
        }

        //render will check again for realpath()
        return $this->view->render($fileName);
    }

    public function url($routeName, array $params = array())
    {
        $router = Container::get('router');
        $url = $router->generate($routeName, $params);
        return $url;
    }

    public function translate($key)
    {
        return Translation::getMessage($key);
    }

    public function module($placeholder)
    {
        return Module::getInstance()->get($placeholder);
    }
}
