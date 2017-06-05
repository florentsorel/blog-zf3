<?php

namespace Application\Infrastructure\Mapper;

use Application\Domain\Common\ValueObject\EmailAddress;
use Application\Domain\User\User;
use InvalidArgumentException;
use Zend\Hydrator\HydratorInterface;

class UserMapper implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if ($object instanceof User !== true) {
            $type = is_object($object)
                ? get_class($object)
                : gettype($object);

            throw new InvalidArgumentException(sprintf(
                'Given value must be an instance of %s; "%s" given',
                User::class,
                $type
            ));
        }

        return [
            'idUser' => $object->getId(),
            'email' => $object->getEmail(),
            'password' => $object->getPassword()
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
        if ($object instanceof User !== true) {
            $type = is_object($object)
                ? get_class($object)
                : gettype($object);

            throw new InvalidArgumentException(sprintf(
                'Given value must be an instance of %s; "%s" given',
                User::class,
                $type
            ));
        }

        $object->setId((int) $data['idUser']);

        if (isset($data['email']) && !empty($data['email'])) {
            $object->setEmail(new EmailAddress($data['email']));
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $object->setPassword($data['password']);
        }
    }
}