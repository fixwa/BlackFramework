<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\ProfileForm;
use Application\Modules\User\Forms\PasswordForm;
use \Black\Redirector;
use \Black\Container;

class ProfileController extends \Black\Controller
{
    public $form;
    public $userModel;
    public $user;

    public function init()
    {
        $this->userModel = Container::get('entity', 'user');
    }

    public function indexAction()
    {
        $userSession = Container::get('userSession');

        $this->user = $this->userModel
            ->where('id', $userSession->id)
            ->findOne();

        $this->view->selectedTab = 'profile';
        $this->form = new ProfileForm($_POST);

        $this->handleProfilePost();
        $this->form->setElementValues([
            'name' => $this->user->name,
            'about' => $this->user->getParameter('about'),
        ]);
        $this->view->form = $this->form;
    }

    public function passwordAction()
    {
        $this->view->selectedTab = 'password';
        $this->form = new PasswordForm();
        $this->handleChangePasswordPost();
        $this->view->form = $this->form;
    }

    /**
     * Handles a change-password form submit
     */
    private function handleChangePasswordPost()
    {
    }

    /**
     * Handles a form submit
     */
    private function handleProfilePost()
    {
        if ($this->form->isSubmitted()) {
            try {
                $data = $this->form->getData();
                $this->user->name = $data['name'];
                unset($data['name']);

                //Merge parameters and update.
                $this->user->mergeParameters($data)->save();

            } catch (\Black\Exceptions\EntityValidationException $e) {
                $failures = $e->getFailures();
                $errors = $e->getErrors();
                $this->form->setErrors($errors);
            } catch (\Exception $e) {
                //Can't save
                var_dump($e->getMessage());
                die;
            }
        }
    }
}
