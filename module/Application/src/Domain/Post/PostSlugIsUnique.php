<?php

namespace Application\Domain\Post;

use Application\Domain\Common\Entity\EntityInterface;
use Application\Domain\Common\Entity\SpecificationInterface;
use Application\Domain\Common\ValueObject\Slug;
use Application\Infrastructure\Repository\PostRepository;

class PostSlugIsUnique implements SpecificationInterface
{
    /** @var PostRepository */
    private $postRepository;

    /**
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->postRepository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy(EntityInterface $candidate)
    {
        if ( ! $candidate instanceof Post) {
            return false;
        }

        /* @var $candidate Post */

        /** @var $existingPost Post */
        $existingPost = $this->postRepository
            ->findBySlug($candidate->getSlug());

        if ($existingPost === null) {
            return true;
        }

        if ($existingPost->sameIdentityAs($candidate) === true) {
            return true;
        }

        return false;
    }
}