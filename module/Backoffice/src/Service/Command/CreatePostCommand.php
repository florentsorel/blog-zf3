<?php

namespace Backoffice\Service\Command;

class CreatePostCommand
{
    /** @var string */
    private $title;

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
        $command->setContent($formData['content']);

        return $command;
    }
}