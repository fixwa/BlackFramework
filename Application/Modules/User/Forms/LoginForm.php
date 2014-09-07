<?php namespace Application\Modules\User\Forms;


class LoginForm extends \Black\Form
{
    public function setConfiguration()
    {
        return [
            'form' => ['action' => '/user/login', 'method' => 'post', 'role' => 'form'],
            'elements' => [
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
