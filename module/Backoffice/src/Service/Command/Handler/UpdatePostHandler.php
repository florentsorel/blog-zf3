<?php

namespace Backoffice\Service\Command\Handler;

use Application\Domain\Common\ValueObject\Slug;
use Application\Infrastructure\Repository\PostRepository;
use Application\Infrastructure\Service\TransactionManager;
use Backoffice\Service\Command\UpdatePostCommand;

class UpdatePostHandler
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

    /**
     * @param UpdatePostCommand $command
     * @throws \Exception
     * @todo Vérifier si le slug existe déjà
     */
    public function handle(UpdatePostCommand $command)
    {
        $this->transactionManager->beginTransaction();

        try {

            $post = $this->postRepository->findById($command->getId());

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