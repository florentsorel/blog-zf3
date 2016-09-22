<?php

namespace Application\Infrastructure\Repository;

use Application\Domain\Entity\Post;

class PostRepository extends AbstractRepository
{
    public function save(Post $post)
    {
        if ($post->getId() !== null) {
            $this->update($post);
        }
        else {
            $this->create($post);
        }
    }

    /**
     * Enregistre un article
     * @param Post $post
     */
    private function create(Post $post)
    {

    }

    /**
     * Met à jour un article
     * @param Post $post
     */
    private function update(Post $post)
    {

    }
}