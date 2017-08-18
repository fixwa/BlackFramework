<?php namespace Black\Exceptions;

class EntityValidationException extends \Exception
{
    private $validator;

    public function __construct($message, $validator)
    {
        $this->validator = $validator;
        parent::__construct($message);
    }

    public function getFailures()
    {
        return $this->validator->getFailures();
    }

    public function getErrors()
    {
        return $this->validator->getErrors();
    }
}
