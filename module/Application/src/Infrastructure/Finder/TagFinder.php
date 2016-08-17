<?php

namespace Application\Infrastructure\Finder;

use Application\View\Model\TagViewModel;
use Illuminate\Support\Collection;

class TagFinder extends AbstractFinder
{
    /**
     * Retourne les tags appartenant à une liste de de post
     *
     * @param array $postIds
     * @return Collection
     */
    public function findByIdPostList(array $postIds)
    {
        $select = "
            SELECT
                Tag.idTag,
                Tag.name,
                PostTag.idPost
            FROM Tag
            
            INNER JOIN PostTag
                ON PostTag.idTag = Tag.idTag
            
            WHERE PostTag.idPost IN ('" . join("','", $postIds) . "')
        ;";

        $statement = $this->db->createStatement($select);
        $result = $statement->execute();

        $tags = new Collection();

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return $tags;
        }

        foreach ($result as $row) {
            $tag = new TagViewModel();
            $this->hydrate($row, $tag);
            $tags->push($tag);
        }

        return $tags;
    }

    /**
     * Retourne les tags appartenant à un idPost
     *
     * @param $idPost
     * @return Collection
     */
    public function findByIdPost($idPost)
    {
        $select = "
            SELECT
                Tag.idTag,
                Tag.name,
                PostTag.idPost
            FROM Tag
            
            INNER JOIN PostTag
                ON PostTag.idTag = Tag.idTag
            
            WHERE PostTag.idPost = :idPost
        ;";

        $statement = $this->db->createStatement($select);
        $result = $statement->execute([
            ':idPost' => $idPost
        ]);

        $tags = new Collection();

        if ($result->isQueryResult() === false
            || $result->count() < 1
        ) {
            return $tags;
        }

        foreach ($result as $row) {
            $tag = new TagViewModel();
            $this->hydrate($row, $tag);
            $tags->push($tag);
        }

        return $tags;
    }

    private function hydrate($row, TagViewModel $tag)
    {
        $tag->id = (int) $row['idTag'];
        $tag->name = $row['name'];
        $tag->idPost = (int) $row['idPost'];
    }
}