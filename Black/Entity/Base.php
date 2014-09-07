<?php namespace Black\Entity;

use Black\Exceptions\MissingModelException;
use Black\Exceptions\MissingValidatorException;

class Base
{
    public $table;
    public $fields = [];
    public $model;
    public $validationRules;

    public function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function setModel($modelClassName)
    {
        $this->model = $modelClassName;
        return $this;
    }

    public function setValidator($validatorName)
    {
        $this->validatorName = $validatorName;
        return $this;
    }

    public function getValidator()
    {
        $validatorClassName = $this->validatorName;
        if (!class_exists($validatorClassName)) {
            throw new MissingValidatorException("Validator for entity does not exists: " . $validatorClassName);
        }
        return new $validatorClassName();
    }

    public function getModel()
    {
        $modelClassName = $this->model;
        if (!class_exists($modelClassName)) {
            throw new MissingModelException("Model for entity does not exists: " . $modelClassName);
        }
        $model = \Model::factory($modelClassName);
        $ret = $model->create();
        $ret->setValidator($this->getValidator());
        return $ret;
    }
}
