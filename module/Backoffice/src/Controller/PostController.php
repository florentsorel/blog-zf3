<?php

namespace Backoffice\Controller;

use Application\Service\PostService;
use Backoffice\Command\Handler\CreatePostHandler;
use Backoffice\Form\CreatePostForm;
use Backoffice\Service\Command\CreatePostCommand;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var CreatePostHandler
     */
    private $createPostHandler;

    /**
     * @param PostService $postService
     * @param CreatePostHandler $createPostHandler
     */
    public function __construct(
        PostService $postService,
        CreatePostHandler $createPostHandler
    ) {
        $this->postService = $postService;
        $this->createPostHandler = $createPostHandler;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postService->findAll()
        ]);
    }

    public function createAction()
    {
        $view = new ViewModel();

        $postCreateForm = new CreatePostForm();
        $view->setVariable('form', $postCreateForm);

        if ($this->getRequest()->isPost() === false) {
            return $view;
        }

        $postCreateForm->setData($this->params()->fromPost());
        if ($postCreateForm->isValid() === false) {
            return $view;
        }

        $formData = $postCreateForm->getData();

        $createCommand = CreatePostCommand::createFromFormData($formData);
        $this->createPostHandler->handle($createCommand);


        return $this->redirect()->toRoute('admin-root/posts');
    }
}