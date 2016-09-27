<?php

namespace Application\Infrastructure\Repository;

use Application\Infrastructure\Mapper\MapperInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;

abstract class AbstractRepository
{
    /** @var DbAdapter */
    protected $db;

    /** @var MapperInterface */
    protected $mapper;

    public function __construct(DbAdapter $dbAdapter, MapperInterface $mapper)
    {
        $this->db = $dbAdapter;
        $this->mapper = $mapper;
    }
}