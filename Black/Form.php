<?php namespace Black;

use Black\Session;

class Form
{
    const SESSION_NAMESPACE = 'FORM_FLASH_DATA';

    protected $config;
    protected $uniqueId;
    protected $csrfHash;

    private $errors;
    private $elementValues = [];

    public function __construct(array $data = null)
    {
        $this->config = array_merge(
            $this->getDefaultConfig(),
            $this->setConfiguration()
        );

        $this->uniqueId = spl_object_hash($this);
        $this->csrfHash = sha1(session_id());
        $this->data = $data;


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
            if (!empty($this->elementValues[$elementName])) {
                $element['value'] = $this->elementValues[$elementName];
            }
            $elementsHtml[] = $this->getElementHtml($elementName, $element);

        }

        $this->data['content'] = implode(PHP_EOL, $elementsHtml);
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function loadDataFromGlobals()
    {
        if (isset($_POST['signature']['uniqueId']) || isset($_POST['signature']['csrfHash'])) {
            Session::set(self::SESSION_NAMESPACE, $_POST);
        }
    }

    public function setElementValues($values)
    {
        $this->elementValues = $values;
    }

    public function getData()
    {
        if (Session::isRegistered(self::SESSION_NAMESPACE)) {
            $data = Session::get(self::SESSION_NAMESPACE);
        } else {
            $data = $this->data;
        }
        unset($data['signature']);
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
        $this->init();
        extract($this->data);
        ob_start();
        require Config::$paths['framework'] . '/Forms/FormContainer.phtml';
        return ob_get_clean();
    }

    public function isSubmitted($checkForPost = false, $checkCsfr = true)
    {
        $submitted = false;

        if (isset($this->data['signature']['uniqueId']) && $this->data['signature']['uniqueId'] === $this->uniqueId) {
            $submitted = true;
        }

        //Insecure check
        if ($checkForPost === true && !empty($_POST)) {
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

    public function getErrorMessages()
    {
        $ret = '';
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                $ret .= '<div class="alert alert-danger" role="alert"><p>' . $error . '</p></div>';
            }
        }
        return $ret;
    }
}
