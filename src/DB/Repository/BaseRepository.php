<?php

namespace PhongoDB\DB\Repository;

use PhongoDB\Interfaces\IEntityInterface;

class BaseRepository
{

    private $entityClass;

    public function __construct($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    public function findAll(Criteria $criteria)
    {

    }

}