<?php namespace Black;

class Application
{
    /**
     * The User-Application' base directory.
     * @var string
     */
    private $applicationBaseDir;

    /**
     * We need to set the Base-Application-Directory, since the framework
     * is now in the "vendor" directory (separated from the actual App).
     *
     * @param string $dir
     */
    public function setAppBaseDir($dir)
    {
        $this->applicationBaseDir = $dir;
    }

    public function init()
    {
        Config::init($this->applicationBaseDir);
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
        if (Config::get('application')->showDebug) {
            Container::get('debug')->showInfo();
        }
    }
}
