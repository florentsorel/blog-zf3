<?php

namespace Application\Infrastructure\Repository;

use Zend\Db\Adapter\Adapter as DbAdapter;

abstract class AbstractRepository
{
    /** @var DbAdapter */
    protected $db;

    protected $mapper;

    public function __construct(DbAdapter $dbAdapter)
    {
        // Récupère le nom de classe instancié
        $calledClassName = (new \ReflectionClass($this))->getShortName();

        /**
         * Supprime le terme Repository de la chaîne
         * $calledClassName = PostRepository
         * $entityName = Post
         */
        $entityName = str_replace('Repository', '', $calledClassName);

        // Récupère le namespace du Mapper ainsi que le nom de la classe
        $className = (new \ReflectionClass('Application\Infrastructure\Mapper\\' . $entityName . 'Mapper'))->getName();

        $this->db = $dbAdapter;
        $this->mapper = new $className;
    }
}