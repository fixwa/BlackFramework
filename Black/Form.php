<?php namespace Black;

use Black\Session;

class Form
{
    const SESSION_NAMESPACE = 'FORM_FLASH_DATA';

    protected $config;
    protected $uniqueId;
    protected $csrfHash;

    public function __construct(array $data = null)
    {
        $this->config = array_merge(
            $this->getDefaultConfig(),
            $this->setConfiguration()
        );

        $this->uniqueId = spl_object_hash($this);
        $this->csrfHash = sha1(session_id());
        $this->data = $data;

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
        $this->loadDataFromGlobals();

        $this->data['formEnctype'] = '';
        $this->data['content'] = '';

        //Form Container
        $formTags = [];
        foreach ($this->config['form'] as $property => $value) {
            $formTags[] = "{$property}=\"{$value}\"";
        }
        $this->data['formTags'] = implode(PHP_EOL, $formTags);

        $elementsHtml = [];

        //Sets this form's signature
        $elementsHtml[] = $this->setSignature();

        //Elements
        foreach ($this->config['elements'] as $elementName => $element) {
            $elementsHtml[] = $this->getElementHtml($elementName, $element);
        }

        $this->data['content'] = implode(PHP_EOL, $elementsHtml);
    }

    public function loadDataFromGlobals()
    {
        if (isset($_POST['signature']['uniqueId'])) {
            Session::set(self::SESSION_NAMESPACE, $_POST);
        }
    }

    public function getData()
    {
        $flashData = Session::get(self::SESSION_NAMESPACE);

        if (Session::isRegistered(self::SESSION_NAMESPACE)) {
            $data = Session::get(self::SESSION_NAMESPACE);
        } else {
            $data = $this->data;
        }

        //unset($data['gajus']);

        return $data;
    }

    public function getElementHtml($elementName, $element)
    {
        $defaults = [
            'id' => $elementName,
            'type' => 'text',
            'name' => $elementName,
            'class' => '',
            'placeholder' => '',
            'value' => '',
        ];

        $data = array_merge($defaults, $element);

        $type = $element['type'];

        if ($type == 'email') {
            $type = 'text';
        }

        ob_start();
        require Config::$paths['framework'] . '/Forms/Element'. ucfirst($type) . '.phtml';
        return ob_get_clean();
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
        $submitted = false;

        if (isset($this->data['signature']['uniqueId']) && $this->data['signature']['uniqueId'] === $this->uniqueId) {
            $submitted = true;
        }

        if ($checkCsfr) {
            $submitted = isset($this->data['signature']['csrfHash'])
                && $this->data['signature']['csrfHash'] === $this->csrfHash;
        }

        return $submitted;
    }

    public function setSignature()
    {
        return '
        <input type="hidden" name="signature[uniqueId]" value="' . $this->uniqueId . '">
        <input type="hidden" name="signature[csrfHash]" value="' . $this->csrfHash . '">';
    }
}
