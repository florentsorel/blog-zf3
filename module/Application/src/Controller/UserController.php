<?php

namespace Application\Controller;

use Application\Form\RegisterForm;
use Application\Service\Command\CreateUserCommand;
use Application\Service\Command\Exception\UserEmailIsNotUniqueException;
use Application\Service\Command\Handler\CreateUserHandler;
use Zend\Http\Response;
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
     * @return ViewModel|Response
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
        try {
            $this->createUserHandler->handle($createCommand);
        }
        catch (UserEmailIsNotUniqueException $exception) {
            $registerForm->invalid();
            $registerForm->get('email')
                ->setMessages(
                    ['L\'adresse email est déjà utilisée par un autre utilisateur']
                );

            return $view;
        }

        $this->flashMessenger()->addMessage(array('success' => 'Custom success message to be here...'));

        return $this->redirect()->toRoute('root');
    }
}