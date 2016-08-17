<?php

namespace Application\Controller;

use Application\Service\PostService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postService->findAll()
        ]);
    }
    /**
     * Affiche le détail d'un article
     *
     * @return array|ViewModel
     */
    public function showAction()
    {
        try {
            $post = $this->postService->findBySlug(
                $this->params()->fromRoute('slug')
            );
            return new ViewModel([
                'post' => $post
            ]);
        }
        catch (\Exception $exception) {
            $this->notFoundAction();
        }
    }
}
