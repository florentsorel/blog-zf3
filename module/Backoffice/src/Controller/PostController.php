<?php

namespace Backoffice\Controller;

use Application\Service\PostService;
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
        die();
        $viewModel = new ViewModel();

        $viewModel->setVariable('posts', $this->postService->findAll());
        return $viewModel;
    }
}