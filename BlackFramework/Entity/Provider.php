<?php namespace Black\Entity;

class Provider
{
    private $entities;

    public function __construct($entities, $sources = null)
    {
        $this->entities = $entities;
    }

    public function init()
    {
        return $this;
    }

    public function getModelFor($entityName, $create = false)
    {
        return $this->entities[$entityName]->getModel($create);
    }
}
