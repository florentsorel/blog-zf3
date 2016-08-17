<?php

namespace Application\View\Model;

use Illuminate\Support\Collection;

class PostViewModel
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $slug;
    /** @var string */
    public $content;
    /** @var Collection */
    public $tags;

    /** @return bool */
    public function hasTags()
    {
        return ($this->tags->count() > 0) === true;
    }

    /**
     * @return string
     */
    public function tagsList()
    {
        $tags = [];

        foreach($this->tags as $tag) {
            $tags[] = $tag->name;
        }

        return implode(', ', $tags);
    }
}