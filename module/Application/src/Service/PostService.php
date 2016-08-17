<?php

namespace Application\Service;

use Application\Exception\NotFoundException;
use Application\Infrastructure\Finder\PostFinder;
use Application\Infrastructure\Finder\TagFinder;
use Illuminate\Support\Collection;

class PostService
{
    /** @var PostFinder */
    protected $postFinder;
    /** @var TagFinder */
    private $tagFinder;

    public function __construct(
        PostFinder $postFinder,
        TagFinder $tagFinder
    )
    {
        $this->postFinder = $postFinder;
        $this->tagFinder = $tagFinder;
    }

    /**
     * Récupère tous les articles ainsi que les tags associés
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAll()
    {
        $posts = new Collection();
        $postIds = [];

        $postsCollection = $this->postFinder->findAll();
        foreach($postsCollection as $post) {
            $postIds[] = $post->id;
        }

        $tagsCollection = $this->tagFinder->findByIdPostList($postIds);

        foreach($postsCollection as $post) {
            $posts->push($post);

            foreach($tagsCollection as $tag) {
                if ($post->id === $tag->idPost) {
                    $post->tags->push($tag);
                }
            }
        }

        return $posts;
    }

    /**
     * Récupère un article par son "id" ainsi que les tags associés
     *
     * @param int $idPost
     * @return \Application\View\Model\PostViewModel|null
     * @throws NotFoundException
     */
    public function findById($idPost)
    {
        $post = $this->postFinder->findById($idPost);

        if ($post === null) {
            throw new NotFoundException("L'article demandé n'existe pas.");
        }

        $tagsCollection = $this->tagFinder->findByIdPost($post->id);

        foreach($tagsCollection as $tag) {
            $post->tags->push($tag);
        }

        return $post;
    }

    /**
     * @param $slug
     * @return \Application\View\Model\PostViewModel|null
     * @throws NotFoundException
     */
    public function findBySlug($slug)
    {
        $post = $this->postFinder->findBySlug($slug);

        if ($post === null) {
            throw new NotFoundException("L'article demandé n'existe pas.");
        }

        $tagsCollection = $this->tagFinder->findByIdPost($post->id);

        foreach($tagsCollection as $tag) {
            $post->tags->push($tag);
        }

        return $post;
    }
}