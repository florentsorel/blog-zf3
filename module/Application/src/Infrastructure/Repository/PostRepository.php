<?php

namespace Application\Infrastructure\Repository;

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

    }
}