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
    public $userSession;

    public function init()
    {
        $this->userModel = Container::get('entity', 'user');
        $this->userSession = Container::get('userSession');

        $this->user = $this->userModel
            ->where('id', $this->userSession->id)
            ->findOne();

        //@todo Use an ACL
        if ($this->userSession->isLoggedIn === false) {
            return;
        }
    }

    public function indexAction()
    {
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

    /**
     * Change Password page
     */
    public function passwordAction()
    {
        $this->view->selectedTab = 'password';
        $this->form = new PasswordForm();
        echo "<div style='clear: both; padding: 10px; margin: 10px; border: 1px solid blue;'><pre><p>" . __METHOD__ . ":" . __LINE__ . "</p>";
        var_dump($this->form);
        echo "</pre></div>";
        $this->handleChangePasswordPost();

        $this->view->form = $this->form;
    }

    /**
     * Upload Profile Image
     * @todo  Resolve validations and security.
     */
    public function uploadAction()
    {
        $this->view->disable();

        //Initialize Upload
        //@see https://github.com/codeguy/Upload
        $storage = new \Upload\Storage\FileSystem(Config::$paths['uploads'] . '/Users/', true);
        $file = new \Upload\File('file', $storage);

        //$new_filename = $this->userSession->uniqueId;
        $file->setName($this->userSession->id);

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

        try {
            $this->user->image = $uploadedFile->name;
            $this->user->save();
        } catch (\Exception $e) {

        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response);
    }

    /**
     * Handles a change-password form submit
     */
    private function handleChangePasswordPost()
    {
        if ($this->form->isSubmitted()) {
            die('1');
            try {
                $data = $this->form->getData();
                echo "<div style='clear: both; padding: 10px; margin: 10px; border: 1px solid blue;'><pre><p>".__METHOD__. ":" .__LINE__."</p>";
                ini_set('xdebug.var_display_max_children', -1);
                ini_set('xdebug.var_display_max_data', 250);
                ini_set('xdebug.var_display_max_depth', 15);
                //debug_print_backtrace();
                var_dump($data);
                //echo '<hr/>';
                //var_dump();
                //echo '<hr/>';
                echo "</pre></div>";die;
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

    /**
     * Handles a form submit
     */
    private function handleProfilePost()
    {
        if ($this->form->isSubmitted()) {
            try {
                $data = $this->form->getData();
                $this->user->name = $data['name'];

                unset($data['image']);
                //$this->user->image = $data['image'];

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
