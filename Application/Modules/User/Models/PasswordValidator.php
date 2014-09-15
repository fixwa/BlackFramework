<?php namespace Application\Modules\User\Models;

class PasswordValidator extends \Black\Validator
{
    protected $equalsToParameterErrorMessage = 'The passwords don\'t match.';

    protected $rules = [
        'password' => [
            'required' => true,
            'minLength' => 5,
            'maxLength' => 50,
            'equalsToParameter' => 'password-confirm'
        ],
    ];
}
