<?php

namespace Application\Infrastructure\Repository;

use Application\Domain\Common\ValueObject\Slug;
use Application\Domain\Post\Post;
use Application\Infrastructure\Mapper\PostMapper;
use Zend\Db\Adapter\Adapter as DbAdapter;

class PostRepository
{
    /** @var DbAdapter */
    protected $db;

    /** @var PostMapper */
    protected $mapper;

    public function __construct(DbAdapter $dbAdapter, PostMapper $mapper)
    {
        $this->db = $dbAdapter;
        $this->mapper = $mapper;
    }

    /**
     * @param int $idPost
     * @return Post|null
     */
    public function findById($idPost)
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
            ':idPost' => $idPost
        ]);

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return null;
        }

        $post = new Post();
        $this->mapper->hydrate($result->current(), $post);

        return $post;
    }

    /**
     * @param Slug $slug
     * @return Post|null
     */
    public function findBySlug(Slug $slug)
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
            ':slug' => $slug->toString()
        ]);

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return null;
        }

        $post = new Post();
        $this->mapper->hydrate($result->current(), $post);

        return $post;
    }

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
        $data = $this->mapper->extract($post);

        // Persiste les données
        $insert = "
            INSERT INTO Post (
                idPost,
                name,
                slug,
                content,
                idUser
            )
            VALUES (
                :idPost,
                :name,
                :slug,
                :content,
                :idUser
            )
        ";

        $bindParams = $data;
        /**
         * @todo récupérer l'id de l'utilisateur lorsque l'implémentation de l'authentification sera en place
         */
        $bindParams['idUser'] = 1;

        $statement = $this->db->createStatement($insert);
        $statement->execute($bindParams);
    }

    /**
     * Met à jour un article
     * @param Post $post
     */
    private function update(Post $post)
    {
        $data = $this->mapper->extract($post);

        // Met à jour les données
        $update = "
            UPDATE Post
            SET
                Post.name = :name,
                Post.slug = :slug,
                Post.content = :content
            WHERE Post.idPost = :idPost
        ";

        $statement = $this->db->createStatement($update);
        $statement->execute([
            ':idPost' => $data['idPost'],
            ':name' => $data['name'],
            ':slug' => $data['slug'],
            ':content' => $data['content']
        ]);
    }
}