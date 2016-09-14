<?php

namespace Application\Infrastructure\Service;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Adapter\Driver\ConnectionInterface;

class TransactionManager
{
    /**
     * @var ConnectionInterface
     */
    private $dbConnection;

    /**
     * @param DbAdapter $dbAdapter
     */
    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbConnection = $dbAdapter->getDriver()->getConnection();
    }

    /**
     * Démarre une transaction
     */
    public function beginTransaction()
    {
        $this->dbConnection->beginTransaction();
    }

    /**
     * Valide une transaction
     */
    public function commit()
    {
        $this->dbConnection->commit();
    }

    /**
     * Annule une transaction
     */
    public function rollback()
    {
        $this->dbConnection->rollback();
    }
}