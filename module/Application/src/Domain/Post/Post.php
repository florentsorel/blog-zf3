<?php

namespace Application\Domain\Post;

use Application\Domain\Common\Entity\AbstractEntity;
use Application\Domain\Common\Entity\EntityInterface;
use Application\Domain\Common\ValueObject\Slug;

class Post extends AbstractEntity implements EntityInterface
{
    /** @var string */
    private $title;

    /** @var Slug */
    private $slug;

    /** @var string */
    private $content;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param Slug $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Permet de vérifier si deux entités ont la même identité
     *
     * @param EntityInterface $candidate
     * @return boolean
     */
    public function sameIdentityAs(EntityInterface $candidate)
    {
        if ( ! $candidate instanceof self) {
            return false;
        }

        return $this->id == $candidate->getId();
    }
}