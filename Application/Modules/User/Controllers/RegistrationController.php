<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\RegistrationForm;
use \Black\Redirector;

class RegistrationController extends \Black\Controller
{
    public function init()
    {
        $this->form = new RegistrationForm($_POST);
        $this->userModel = \Black\Container::get('entities')->getModelFor('user');
    }

    public function registrationAction()
    {
        if ($this->form->isSubmitted()) {
            try {
                $this->userModel->saveFromArray($this->form->getData());
                Redirector::getInstance()
                    ->toRoute('userRegistrationSuccess')
                    ->go();
            } catch (\Black\Exceptions\EntityValidationException $e) {

                $failures = $e->getFailures();
                $errors = $e->getErrors();
                $this->form->setErrors($errors);
            } catch (\Exception $e) {
                //Can't save
            }


        }

        $this->view->form = $this->form;
    }

    public function successAction()
    {

    }
}
