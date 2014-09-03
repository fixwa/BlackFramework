<?php namespace Black;

class Application
{
    public function init()
    {
        Config::init();
        Container::init();

        $this->dispatch();
    }

    public function dispatch()
    {
        Container::get('dispatcher')->dispatch();
        $controller = Container::get('controller');
        //$controller->renderView();
    }

    public function __destruct()
    {
        Container::get('debug')->showInfo();
    }
}
