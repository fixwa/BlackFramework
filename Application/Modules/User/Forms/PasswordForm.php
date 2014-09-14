<?php namespace Application\Modules\User\Forms;


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
}
