<?php

namespace Application\Domain\Common\ValueObject;

use Application\Domain\Common\Entity\EntityNotFoundException;
use Application\Domain\User\User;
use Application\Infrastructure\Repository\UserRepository;

class EmailIsUnique
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function isSatisfiedBy(User $user)
    {
        try {
            $this->userRepository->findByEmail($user->getEmail());
        }
        catch (EntityNotFoundException $exception) {
            return true;
        }

        return false;
    }
}