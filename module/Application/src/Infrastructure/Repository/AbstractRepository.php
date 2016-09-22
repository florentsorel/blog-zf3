<?php

namespace Application\Infrastructure\Repository;

use Zend\Db\Adapter\Adapter as DbAdapter;

abstract class AbstractRepository
{
    /** @var DbAdapter */
    protected $dbAdapter;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}