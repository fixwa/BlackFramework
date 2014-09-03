<?php
namespace Black;

use \Black\Config;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = Container::get('view');
    }

    /**
     * Renders the view for the current controller instance.
     *
     */
    public function postDispatch()
    {
        if ($this->view->isDisabled()) {
            return;
        }
        $viewFile = $this->determineViewFile();
        $templateContent = $this->view->render($viewFile);

        if (empty($this->view->layout)) {
            $layoutFilePath = Config::$paths['application'] . DIRECTORY_SEPARATOR .
                 Config::get('application')->defaults->layout;
            $this->view->layout = $layoutFilePath;
        }

        echo $this->view->render($this->view->layout, ['TEMPLATE_CONTENT' => $templateContent]);
    }

    private function determineViewFile()
    {
        $dispatcher = Container::get('dispatcher');

        $viewBaseFolder   = ucfirst(str_replace('Controller', '', $dispatcher->controllerName));
        $viewBaseFileName = strtolower(str_replace('Action', '', $dispatcher->controllerAction)) . '.phtml';

        $moduleViewsFolder = Config::$paths['application'] .  "/Modules/{$dispatcher->module}/Views";
        $this->view->moduleViewsFolder = $moduleViewsFolder;

        return "{$moduleViewsFolder}/{$viewBaseFolder}/{$viewBaseFileName}";
    }
}
