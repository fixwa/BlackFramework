<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\RegistrationForm;
use \Black\Redirector;
use \Black\Container;

class RegistrationController extends \Black\Controller
{
    public function init()
    {
        $this->form = new RegistrationForm($_POST);
        $this->userModel = Container::get('entity', ['user', true]);
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
                var_dump($e->getMessage());
                die;

                Redirector::getInstance()
                    ->toRoute('error')
                    //->setMessages(['error' => $e->getMessage()])
                    ->go();
            }


        }

        $this->view->form = $this->form;
    }
}
