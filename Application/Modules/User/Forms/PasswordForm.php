<?php namespace Application\Modules\User\Forms;

use \Black\Exceptions\EntityValidationException;
use \Application\Modules\User\Models\PasswordValidator;

class PasswordForm extends \Black\Form
{

    public function setConfiguration()
    {
        return [
            'form' => ['action' => '/user/password', 'method' => 'post', 'role' => 'form'],
            'elements' => [
                'password' => [
                    'type' => 'password',
                    'label' => 'Contraseña'
                ],
                'password-confirm' => [
                    'type' => 'password',
                    'label' => 'Confirmar Contraseña'
                ],
                'submit' => [
                    'type' => 'submit',
                    'value' => 'Enviar'
                ],
            ]
        ];
        //$this->form->loadFromGlobals();
    }

    public function validate()
    {
        $data = $this->getData();

        $validator = new PasswordValidator();

        if (!$validator->passes($data)) {
            throw new EntityValidationException('Incorrect password.', $validator);
        }
        return true;
    }
}
