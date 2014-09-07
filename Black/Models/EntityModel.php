<?php namespace Black\Models;

use \Black\Exceptions\EntityValidationException;

class EntityModel extends \Model
{
    public static $_table_use_short_name = true;
    private $validator;

    public function __construct()
    {
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function saveFromArray($data)
    {
        $this->validate($data);
        foreach ($data as $field => $value) {
            $this->{$field} = $value;
        }

        if (isset($this->date_created)) {
            $this->set_expr('date_created', 'NOW()');
        }
        if (isset($this->date_modified)) {
            $this->date_modified = null;
        }

        return parent::save();
    }

    public function save()
    {
        if (isset($this->date_modified)) {
            $this->set_expr('date_modified', 'NOW()');
        }
        return parent::save();
    }

    /**
     * Throws exception on failure.
     */
    public function validate($data)
    {
        $passes = $this->validator->passes($data);
        if (!$passes) {
            throw new EntityValidationException("Validation failed.", $this->validator);
        }
        return $this;
    }
}
