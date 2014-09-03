<?php namespace Black;

class Form
{
    protected $config;

    public function __construct()
    {
        $this->config = array_merge(
            $this->getDefaultConfig(),
            $this->setConfiguration()
        );
        $this->init();
    }

    public function getDefaultConfig()
    {
        return [
            'form' => ['action' => '#', 'method' => 'post'],
            'elements' => []
        ];
    }

    /**
     * overload this
     */
    public function setConfiguration()
    {
        return null;
    }

    public function init()
    {
        $this->data['formEnctype'] = '';
        $this->data['content'] = '';

        //Form Container
        $formTags = [];
        foreach ($this->config['form'] as $property => $value) {
            $formTags[] = "{$property}=\"{$value}\"";
        }
        $this->data['formTags'] = implode(PHP_EOL, $formTags);

        //Elements

        $elementsHtml = [];
        foreach ($this->config['elements'] as $elementName => $element) {
            $elementsHtml[] = $this->getElementHtml($elementName, $element);
        }
        $this->data['content'] = implode(PHP_EOL, $elementsHtml);

    }

    public function getElementHtml($elementName, $element)
    {

    }

    public function render()
    {
        extract($this->data);
        ob_start();
        require Config::$paths['framework'] . '/Forms/FormContainer.phtml';
        return ob_get_clean();
    }

    public function isSubmitted($checkCsfr = true)
    {
    }
}
