<?php

namespace Application\Controller;

use Application\Form\RegisterForm;
use Application\Service\Command\CreateUserCommand;
use Application\Service\Command\Handler\CreateUserHandler;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    /** @var CreateUserHandler */
    private $createUserHandler;

    public function __construct(CreateUserHandler $createUserHandler)
    {
        $this->createUserHandler = $createUserHandler;
    }

    /**
     * Affiche le formulaire de connexion
     *
     * @return ViewModel
     */
    public function loginAction()
    {

    }

    /**
     * Affiche le formulaire d'inscription
     *
     * @return ViewModel
     */
    public function registerAction()
    {
        $view = new ViewModel();

        $registerForm = new RegisterForm();
        $view->setVariable('form', $registerForm);

        if ($this->getRequest()->isPost() === false) {
            return $view;
        }

        $registerForm->setData($this->params()->fromPost());
        if ($registerForm->isValid() === false) {
            return $view;
        }

        $formData = $registerForm->getData();

        $createCommand = CreateUserCommand::createFromFormData($formData);
        $this->createUserHandler->handle($createCommand);
    }
}