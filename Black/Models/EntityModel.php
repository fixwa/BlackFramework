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
        $this->set_expr('date_created', 'NOW()');
        $this->date_modified = null;
        return $this->save();
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
