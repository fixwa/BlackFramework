<?php namespace Application\Modules\User\Forms;


class ProfileForm extends \Black\Form
{
    public function setConfiguration()
    {
        return [
            'form' => ['action' => '/user/profile', 'method' => 'post'],
            'elements' => [
                'name' => [
                    'type' => 'text',
                    'label' => 'Nombre'
                ],
                'about' => [
                    'type' => 'textarea',
                    'label' => 'Acerca de ti',
                    'rows'  => 8
                ],
                'submit' => [
                    'type' => 'submit',
                    'value' => 'Enviar'
                ],
            ]
        ];
    }
}
