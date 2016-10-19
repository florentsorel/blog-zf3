<?php

namespace Backoffice\Controller;

use Application\Service\PostService;
use Backoffice\Form\CreatePostForm;
use Backoffice\Form\UpdatePostForm;
use Backoffice\Service\Command\CreatePostCommand;
use Backoffice\Service\Command\Handler\CreatePostHandler;
use Backoffice\Service\Command\Handler\UpdatePostHandler;
use Backoffice\Service\Command\UpdatePostCommand;
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
     * @var UpdatePostHandler
     */
    private $updatePostHandler;

    /**
     * @param PostService $postService
     * @param CreatePostHandler $createPostHandler
     * @param UpdatePostHandler $updatePostHandler
     */
    public function __construct(
        PostService $postService,
        CreatePostHandler $createPostHandler,
        UpdatePostHandler $updatePostHandler
    ) {
        $this->postService = $postService;
        $this->createPostHandler = $createPostHandler;
        $this->updatePostHandler = $updatePostHandler;
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

    public function editAction()
    {
        $idPost = $this->params()->fromRoute('id');

        $post = $this->postService->findById($idPost);

        $postUpdateForm = new UpdatePostForm();
        $postUpdateForm->setDataFromPostViewModel($post);

        $view = new ViewModel();
        $view->setVariable('form', $postUpdateForm);

        if ($this->getRequest()->isPost() === false) {
            return $view;
        }

        $postUpdateForm->setData($this->params()->fromPost());
        if ($postUpdateForm->isValid() === false) {
            return $view;
        }

        $formData = $postUpdateForm->getData();

        $updateCommand = UpdatePostCommand::createFromFormData($formData);
        $updateCommand->idPost = $idPost;
        $this->updatePostHandler->handle($updateCommand);

        $view->setVariable('success', true);
        return $view;
    }
}