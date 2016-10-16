<?php

namespace Application\Domain\Post;

use Application\Infrastructure\Repository\PostRepository;

class PostSlugUniquenessEnforcer
{
    /** @var PostSlugIsUnique */
    private $postSlugIsUnique;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postSlugIsUnique = new PostSlugIsUnique($postRepository);
    }

    /**
     * @param Post $post
     */
    public function enforcePostSlugUniqueness(Post $post)
    {
        $uniqueSuffix = 1;
        $baseSlugString = $post->getSlug();
        while ( ! $this->postSlugIsUnique->isSatisfiedBy($post)) {
            // Ajoute un suffixe automatiquement à l'outil
            $uniqueSuffix++;
            $post->setSlug("{$baseSlugString}-{$uniqueSuffix}");
        }
    }
}