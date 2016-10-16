<?php

namespace Backoffice\Service\Command\Handler;

use Application\Domain\Common\ValueObject\Slug;
use Application\Domain\Post\Post;
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
        PostRepository $postRepository,
        TransactionManager $transactionManager
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
                 ->setSlug(Slug::createFromString($command->getSlug())->toString())
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