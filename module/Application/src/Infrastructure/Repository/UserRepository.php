<?php

namespace Application\Infrastructure\Repository;

use Application\Domain\Common\Entity\EntityNotFoundException;
use Application\Domain\Common\ValueObject\EmailAddress;
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
        // Extrait les données de l'entité
        $data = $this->userMapper->extract($user);

        $insert = <<<SQL
            INSERT INTO User (
                idUser,
                email,
                password
            )
            VALUES (
                :idUser,
                :email,
                :password
            );
SQL;
        $statement = $this->db->createStatement($insert);
        $statement->execute($data);
    }

    public function findByEmail(EmailAddress $email)
    {
        $select = <<<SQL
            SELECT
                User.idUser,
                User.email
            FROM User
            WHERE User.email = :email;
SQL;

        $statement = $this->db->createStatement($select);
        $result = $statement->execute([
            ':email' => $email->toString()
        ]);

        if ($result->isQueryResult() === false || $result->count() < 1) {
            throw new EntityNotFoundException(sprintf(
                'User with email address "%s" does not exist',
                $email->toString()
            ));
        }

        $user = new User();
        $this->userMapper->hydrate($result->current(), $user);

        return $user;

    }
}