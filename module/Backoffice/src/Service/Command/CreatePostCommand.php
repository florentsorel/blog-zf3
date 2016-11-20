<?php

namespace Backoffice\Service\Command;

use Application\Domain\Common\ValueObject\Slug;

class CreatePostCommand
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

    public static function createFromFormData(array $formData)
    {
        $command = new self();
        $command->setTitle($formData['title']);
        $command->setSlug(Slug::createFromString($formData['title']));
        $command->setContent($formData['content']);

        return $command;
    }
}