<?php

namespace Application\Infrastructure\Finder;

use Zend\Db\Adapter\Adapter as DbAdapter;

abstract class AbstractFinder
{
    /** @var DbAdapter */
    protected $db;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->db = $dbAdapter;
    }
}