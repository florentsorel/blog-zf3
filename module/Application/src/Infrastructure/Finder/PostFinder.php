<?php

namespace Application\Infrastructure\Finder;

use Application\View\Model\PostViewModel;
use Illuminate\Support\Collection;

class PostFinder extends AbstractFinder
{
    /**
     * Retourne la liste des articles
     *
     * @param string $order
     * @return Collection
     */
    public function findAll($order = 'DESC')
    {
        $select = "
            SELECT 
                Post.idPost,
                Post.name,
                Post.slug,
                Post.content
            FROM Post
            
            ORDER BY Post.idPost {$order};  
        ";

        $statement = $this->db->createStatement($select);
        $result = $statement->execute();

        $posts = new Collection();

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return $posts;
        }

        foreach ($result as $row) {
            $post = new PostViewModel();
            $this->hydrate($row, $post);
            $posts->push($post);
        }

        return $posts;
    }

    /**
     * Retourne une vue d'article à partir de son id
     *
     * @param int $postId
     * @return PostViewModel|null
     */
    public function findById($postId)
    {
        $select = "
            SELECT
                Post.idPost,
                Post.name,
                Post.slug,
                Post.content
            FROM Post
            
            WHERE Post.idPost = :idPost
            LIMIT 1
        ";

        $statement = $this->db->createStatement($select);
        $result = $statement->execute([
            ':idPost' => $postId
        ]);

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return null;
        }

        $post = new PostViewModel();
        $this->hydrate($result->current(), $post);

        return $post;
    }

    /**
     * Retourne une vue d'article à partir de son slug
     *
     * @param string $slug
     * @return PostViewModel|null
     */
    public function findBySlug($slug)
    {
        $select = "
            SELECT
                Post.idPost,
                Post.name,
                Post.slug,
                Post.content
            FROM Post
            
            WHERE Post.slug = :slug
            LIMIT 1
        ";

        $statement = $this->db->createStatement($select);
        $result = $statement->execute([
            ':slug' => (string) $slug
        ]);

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return null;
        }

        $post = new PostViewModel();
        $this->hydrate($result->current(), $post);

        return $post;
    }

    /**
     * @param array $row
     * @param PostViewModel $post
     */
    private function hydrate(array $row, PostViewModel $post)
    {
        $post->id = (int) $row['idPost'];
        $post->name = $row['name'];
        $post->slug = $row['slug'];
        $post->content = $row['content'];
        $post->tags = new Collection();
    }
}