<?php

namespace Application\Service\Command\Handler;

use Application\Infrastructure\Repository\UserRepository;
use Application\Infrastructure\Service\TransactionManager;
use Application\Service\Command\CreateUserCommand;

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
        // @todo save the user
    }
}