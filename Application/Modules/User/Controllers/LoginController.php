<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\LoginForm;
use \Black\Redirector;
use \Black\Container;
use \Black\Session;

class LoginController extends \Black\Controller
{
    public function init()
    {
        $this->form = new LoginForm($_POST);
        $this->userModel = Container::get('entity', 'user');
    }

    public function loginAction()
    {
        if ($this->form->isSubmitted(true, false)) {
            try {
                $data = $this->form->getData();

                $user = $this->userModel
                    ->where('email', $data['email'])
                    ->where('password', $data['password'])
                    ->findOne();

            } catch (\Black\Exceptions\EntityValidationException $e) {
                $failures = $e->getFailures();
                $errors = $e->getErrors();
                $this->form->setErrors($errors);
            } catch (\Exception $e) {
                //Can't save
                var_dump($e->getMessage());
                die;
            }

            if (!empty($user)) {
                //Save extra parameters into user's account.
                $data = [];
                $data['lastLogin']['date'] = now();
                $data['lastLogin']['ip'] = \Black\Request::getIp();
                $data['lastLogin']['uniqueId'] = uniqid('[u:' . $user->id . ']');
                $user->mergeParameters($data)->save();

                //Update the current session status.
                $user->ip = $parameters->lastLogin->ip;
                $user->uniqueId = $parameters->lastLogin->uniqueId;
                $user->isAdmin = ($user->role === 'admin');
                $user->isLoggedIn = true;
                Session::set('user', $user);

                Redirector::getInstance()
                    ->toRoute('userDashboard')
                    ->go();
            }

        }

        $this->view->form = $this->form;
    }

    public function logoutAction()
    {
        Session::destroy();
    }
}
