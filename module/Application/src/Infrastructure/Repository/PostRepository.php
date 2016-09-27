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
        $data = $this->mapper->extract($post);

        // Persiste les données
        $insert = "
            INSERT INTO Post (
                idPost,
                name,
                content,
                idUser
            )
            VALUES (
                :idPost,
                :name,
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