<?php

namespace Backoffice\Controller;

use Application\Service\PostService;
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
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
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

        // Lancer le handler sur la command

        return $this->redirect()->toRoute('admin-root/posts');
    }
}