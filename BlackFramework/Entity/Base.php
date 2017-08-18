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
        $this->modelClassName = $modelClassName;
        return $this;
    }

    public function setValidator($validatorName)
    {
        $this->validatorName = $validatorName;
        return $this;
    }

    public function getValidator()
    {
        $validator = null;
        if (!empty($this->validatorName)) {
            $validatorClassName = $this->validatorName;
            if (!class_exists($validatorClassName)) {
                throw new MissingValidatorException("Validator for entity does not exists: " . $validatorClassName);
            }
            $validator = new $validatorClassName();
        }
        return $validator;
    }

    public function getModel($create = false)
    {
        if (!class_exists($this->modelClassName)) {
            throw new MissingModelException("Model for entity does not exists: " . $this->modelClassName);
        }
        $this->model = \Model::factory($this->modelClassName);

        if ($create) {
            $this->create();
        }
        return $this->model;
    }

    public function create()
    {
        $this->model = $this->model->create();
        $this->model->setValidator($this->getValidator());
        return $this->model;
    }
}
