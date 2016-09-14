<?php

namespace Backoffice\Command\Handler;

use Application\Domain\Entity\Post;
use Application\Infrastructure\Repository\PostRepository;
use Application\Infrastructure\Service\TransactionManager;
use Backoffice\Service\Command\CreatePostCommand;

class CreatePostHandler
{
    /**
     * @var TransactionManager
     */
    public $transactionManager;

    /**
     * @var PostRepository
     */
    public $postRepository;

    public function __construct(
        TransactionManager $transactionManager,
        PostRepository $postRepository
    ) {
        $this->transactionManager = $transactionManager;
        $this->postRepository = $postRepository;
    }

    public function handle(CreatePostCommand $command)
    {
        $this->transactionManager->beginTransaction();

        try {
            $post = new Post();
            $post->setTitle($command->getTitle())
                ->setContent($command->getContent());

            $this->postRepository->save($post);
        }
        catch(\Exception $exception) {
            $this->transactionManager->rollback();
            throw $exception;
        }

        $this->transactionManager->commit();
    }
}