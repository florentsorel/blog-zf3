<?php

namespace Application\Infrastructure\Mapper;

use Application\Domain\Entity\Post;
use InvalidArgumentException;
use Zend\Hydrator\HydratorInterface;

class PostMapper implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if ($object instanceof Post !== true) {
            $type = is_object($object)
                ? get_class($object)
                : gettype($object);

            $class = Post::class;
            throw new InvalidArgumentException(
                "Excepting $class for parameter [object]; $type given"
            );
        }

        return [
            'idPost' => $object->getId(),
            'name' => $object->getTitle(),
            'slug' => $object->getSlug(),
            'content' => $object->getContent()
        ];
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if ($object instanceof Post !== true) {
            $type = is_object($object)
                ? get_class($object)
                : gettype($object);

            $class = Post::class;
            throw new InvalidArgumentException(
                "Excepting $class for parameter [object]; $type given"
            );
        }

        $object->setId((int) $data['idPost']);

        if (isset($data['name']) && !empty($data['name'])) {
            $object->setTitle($data['name']);
        }
        if (isset($data['slug']) && !empty($data['slug'])) {
            $object->setSlug($data['slug']);
        }
        if (isset($data['content']) && !empty($data['content'])) {
            $object->setContent($data['content']);
        }
    }
}