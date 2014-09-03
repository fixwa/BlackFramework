<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\RegistrationForm;

class RegistrationController extends \Black\Controller
{
    public function init()
    {
        $this->form = new RegistrationForm();

    }

    public function registrationAction()
    {
        //$this->view->disable();
        if ($this->form->isSubmitted()) {
            echo '<p>WAS SUBMITTED.</p>';
        } else {
            echo '<p>NOT SUBMITTED.</p>';
        }

        $this->view->form = $this->form;
    }

    public function registrationPostAction()
    {
        $this->view->disable();
    }
}
