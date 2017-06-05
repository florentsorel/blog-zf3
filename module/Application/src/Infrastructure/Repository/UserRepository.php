<?php

namespace Application\Infrastructure\Repository;

use Application\Domain\User\User;
use Application\Infrastructure\Mapper\UserMapper;
use Zend\Db\Adapter\Adapter as DbAdapter;

class UserRepository
{
    /**
     * @var DbAdapter
     */
    protected $db;

    /**
     * @var UserMapper
     */
    protected $userMapper;

    public function __construct(DbAdapter $dbAdapter, UserMapper $userMapper)
    {
        $this->db = $dbAdapter;
        $this->userMapper = $userMapper;
    }

    /**
     * Persiste les données
     * @param User $user
     */
    public function save(User $user)
    {
        if ($user->getId() !== null) {

        }
        else {
            $this->create($user);
        }
    }

    /**
     * Enregistre un utilisateur
     * @param User $user
     */
    private function create(User $user)
    {
        $data = $this->userMapper->extract($user);
    }
}