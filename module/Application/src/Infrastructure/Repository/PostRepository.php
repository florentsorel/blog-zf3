<?php

namespace Application\Infrastructure\Repository;

use Application\Domain\Entity\Post;

class PostRepository
{
    public function save(Post $post)
    {
        \Zend\Debug\Debug::dump("saved!!!");
    }
}