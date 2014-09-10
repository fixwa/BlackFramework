<?php namespace Application\Modules\User\Controllers;

use Application\Modules\User\Forms\ProfileForm;
use Application\Modules\User\Forms\PasswordForm;
use \Black\Redirector;
use \Black\Container;
use \Black\Config;

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
            'image' => '/Assets/Uploads/Users/' . $this->user->image,
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
     * Upload Profile Image
     * @return [type] [description]
     * @todo  Resolve validations and security.
     */
    public function uploadAction()
    {
        $userSession = Container::get('userSession');
        if ($userSession->isLoggedIn === false) {
            return;
        }
        $this->view->disable();

        //Initialize Upload
        //@see https://github.com/codeguy/Upload
        $storage = new \Upload\Storage\FileSystem(Config::$paths['uploads'] . '/Users/', true);
        $file = new \Upload\File('file', $storage);

        //$new_filename = $userSession->uniqueId;
        $file->setName($userSession->id);

        $file->addValidations([
            //new \Upload\Validation\Mimetype(array('image/jpg'/*, 'image/gif'*/)),
            new \Upload\Validation\Size('15M')
        ]);

        $response = new \stdClass;
        // Try to upload file
        try {
            // Success!
            $file->upload();

            $uploadedFile = new \stdClass;
            $uploadedFile->name = $file->getNameWithExtension();
            $uploadedFile->size = $file->getSize();
            $uploadedFile->md5 = rand(); //not the actual md5 :/
            $uploadedFile->thumbnailUrl = '/Assets/Uploads/Users/' . $file->getNameWithExtension();

            $response->files = [];
            $response->files[] = $uploadedFile;
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
            //print_r($errors);
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response);
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
                $this->user->image = $data['image'];

                //Merge parameters and update.
                $this->user->mergeParameters($data)->save();

                Redirector::getInstance()
                    ->toRoute('userProfile')
                    //->setMessages(['error' => $e->getMessage()])
                    ->go();

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
