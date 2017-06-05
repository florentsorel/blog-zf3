<?php

namespace Application\Service\Command\Handler;

use Application\Domain\Common\ValueObject\EmailAddress;
use Application\Domain\Common\ValueObject\EmailIsUnique;
use Application\Domain\Common\ValueObject\Password;
use Application\Domain\User\User;
use Application\Infrastructure\Repository\UserRepository;
use Application\Infrastructure\Service\TransactionManager;
use Application\Service\Command\CreateUserCommand;
use Application\Service\Command\Exception\UserEmailIsNotUniqueException;

class CreateUserHandler
{
    /** @var TransactionManager */
    public $transactionManager;

    /** @var UserRepository */
    public $userRepository;

    public function __construct(
        UserRepository $userRepository,
        TransactionManager $transactionManager
    ) {
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
    }

    public function handle(CreateUserCommand $command)
    {
        $password = new Password($command->getPassword());

        $user = new User();
        $user->setEmail(new EmailAddress($command->getEmail()))
            ->setPassword(Password::generateHashFrom($password));

        $emailIsUnique = new EmailIsUnique($this->userRepository);
        if ($emailIsUnique->isSatisfiedBy($user) === false) {
            throw UserEmailIsNotUniqueException::fromEmail($command->getEmail());
        }

        $this->userRepository->save($user);
    }
}