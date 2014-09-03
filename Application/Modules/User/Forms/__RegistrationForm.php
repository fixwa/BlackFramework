<?php namespace Application\Modules\User\Forms;

use FormManager\Form;
use FormManager\Inputs\Input;
use FormManager\Fields\Field;

class RegistrationForm extends Form
{
    public function __construct()
    {
        $this->action('/user/registration')->method('post');
        $this->attr([
            'role' => 'form'
        ]);
        $this->add([
            'name' => Field::text()
                ->label('Your name')
                ->placeholder('Your name')
                ->class('form-control')
                ->maxlength(50)
                ->required()
                ->render(function ($input, $label, $labelError) {
                    return "<div class='form-group'>{$label} {$input} {$labelError}</div>";
                }),

            'email' => Field::email()
                ->label('Your email')
                ->placeholder('email@example.com')
                ->class('form-control')
                ->required()
                ->render(function ($input, $label, $labelError) {
                    return "<div class='form-group'>{$label} {$input} {$labelError}</div>";
                }),

            'password' => Field::password()
                ->label('Password')
                ->class('form-control')
                ->minlength(5)
                ->maxlength(50)
                ->required()
                ->render(function ($input, $label, $labelError) {
                    return "<div class='form-group'>{$label} {$input} {$labelError}</div>";
                }),

            'password-confirm' => Field::password()
                ->label('Confirm Password')
                ->class('form-control')
                ->minlength(5)
                ->maxlength(50)
                ->required()
                ->render(function ($input, $label, $labelError) {
                    return "<div class='form-group'>{$label} {$input} {$labelError}</div>";
                }),

            'action' => Field::choose([
                'save' => Field::submit()
                    ->html('Register')
                    ->class('btn btn-primary'),
            ])
        ]);
    }
}
