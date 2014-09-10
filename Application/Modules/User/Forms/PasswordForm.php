<?php namespace Application\Modules\User\Forms;


class PasswordForm extends \Black\Form
{
    public function setConfiguration()
    {
        return [
            'form' => ['action' => '/user/login', 'method' => 'post', 'role' => 'form'],
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

    /**
     * Overloads parent::getData
     */
    public function getData()
    {
        $data = parent::getData();
        $data['email'] = strtolower($data['email']);
        return $data;
    }
}
