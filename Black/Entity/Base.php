<?php namespace Black\Entity;

use Black\Exceptions\MissingModelException;

class Base
{
    public $table;
    public $fields = [];
    public $model;

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

    public function getModel()
    {
        $modelClassName = $this->model;
        if (!class_exists($modelClassName)) {
            throw new MissingModelException("Model for entity does not exists: " . $modelClassName);
        }
        return \Model::factory($modelClassName);
    }
}
