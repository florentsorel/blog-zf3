<?php

namespace Backoffice\Command\Handler;

use Application\Domain\Entity\Post;
use Backoffice\Service\Command\CreatePostCommand;

class CreatePostHandler
{
    public $transactionManager;

    public $postRepository;

    public function __construct($transactionManager, $postRepository)
    {
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
            $this->transactionManager->rollBack();
            throw $exception;
        }
        $this->transactionManager->commit();
    }
}