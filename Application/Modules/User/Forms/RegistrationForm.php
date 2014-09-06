<?php namespace Application\Modules\User\Forms;


class RegistrationForm extends \Black\Form
{
    public function setConfiguration()
    {
        return [
            'form' => ['action' => '/user/registration', 'method' => 'post'],
            'elements' => [
                'name' => [
                    'type' => 'text',
                    'label' => 'Nombre'
                ],
                'email' => [
                    'type' => 'email',
                    'label' => 'E-Mail'
                ],
                'password' => [
                    'type' => 'password',
                    'label' => 'Contraseña'
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
