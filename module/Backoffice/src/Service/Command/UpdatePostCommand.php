<?php

namespace Backoffice\Service\Command;

use Application\Domain\Common\ValueObject\Slug;

class UpdatePostCommand
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var Slug */
    private $slug;

    /** @var string */
    private $content;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param Slug $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param int $idPost
     * @param array $formData
     * @return UpdatePostCommand
     */
    public static function createFromFormData($idPost, array $formData)
    {
        $command = new self();
        $command->setId($idPost);
        $command->setTitle($formData['title']);
        $command->setSlug(Slug::createFromString($formData['slug']));
        $command->setContent($formData['content']);

        return $command;
    }
}