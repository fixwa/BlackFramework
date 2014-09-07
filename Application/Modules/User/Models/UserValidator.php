<?php namespace Application\Modules\User\Models;

class UserValidator extends \Black\Validator
{
    protected $isUniqueErrorMessage = '%s is already in use.';

    protected $rules = [
        'name' => ['required' => true],
        'email' => ['required' => true, 'email' => true, 'isUnique' => true],
        'password' => ['required' => true, 'minLength' => 5, 'maxLength' => 50]
    ];

    //@todo Add logic
    public function isUnique($value, $param)
    {
        return true;
    }
}
