<?php
namespace Black;

use Black\View\ViewHelper;
use \Black\Config;

class View
{
    public $layout;
    public $moduleViewsFolder;
    public $disabled = false;

    public $styleSheets = [];

    protected $data = [];


    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __call($name, $args = null)
    {
        $viewHelper = new ViewHelper($this);
        return $viewHelper->callMethod($name, $args);
    }

    public function disable($value = true)
    {
        $this->disabled = $value;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function render($template = '', $data = [])
    {
        $file = realpath($template);

        if (!is_file($template)) {
            throw new \RuntimeException("View cannot render {$template} because the template does not exist.");
        }

        $data = array_merge($this->data, (array)$data);
        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
