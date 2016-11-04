<?php

namespace PhongoDB\DB\Repository;

use PhongoDB\ArrayList;
use PhongoDB\DB\Connection;
use PhongoDB\DB\Criteria;
use PhongoDB\Interfaces\IEntityInterface;

class BaseRepository
{

    private $entityClass;
    private $dbCollection;

    public function __construct(IEntityInterface $entityClass)
    {
        $this->entityClass = $entityClass;
        $this->dbCollection = Connection::getCollection($entityClass->getCollection());
    }

    public function save(IEntityInterface &$entity, $validate = true)
    {
        if ($validate && !$entity->validate())
            return false;

        $oData = $entity->getAttributes();
        if (!isset($oData['id']) || (isset($oData['id']) && is_null($oData['id']))) {
            $response = $this->dbCollection->insert($oData);
            if (!is_null($response['err']))
                return false;

            $entity->setAttributes(['id' => $oData['_id']]);
        } else {
            $id = $oData['id'];
            unset($oData['id']);

            $response = $this->dbCollection->update([
                '_id' => $id instanceof \MongoId ? $id : new \MongoId($id)
            ], $oData);
            if (!is_null($response['err']))
                return false;
        }

        return true;
    }

    public function find($criteria = null)
    {
        if (!($criteria instanceof Criteria))
            $criteria = $this->buildCriteria($criteria);

        $cursor = $this->dbCollection->find($criteria->getWhere());
        if (!is_null($criteria->getLimit()))
            $cursor->limit($criteria->getLimit());

        if (!is_null($criteria->getOffset()))
            $cursor->skip($criteria->getOffset());

        $oData = $cursor->getNext();
        if (is_array($oData)) {
            $oEntity = clone $this->entityClass;
            $oEntity->setAttributes($oData);
            return $oEntity;
        }

        return null;
    }

    public function findAll($criteria = null)
    {
        $collection = new ArrayList($this->entityClass);

        if (!($criteria instanceof Criteria))
            $criteria = $this->buildCriteria($criteria);

        $cursor = $this->dbCollection->find($criteria->getWhere());
        if (!is_null($criteria->getLimit()))
            $cursor->limit($criteria->getLimit());

        if (!is_null($criteria->getOffset()))
            $cursor->skip($criteria->getOffset());

        foreach ($cursor as $oData) {
            $oEntity = clone $this->entityClass;
            $oEntity->setAttributes($oData);
            $collection->add($oEntity);
        }

        return $collection;
    }

    private function buildCriteria($filter)
    {
        $criteria = new Criteria;
        if (is_null($filter))
            return $criteria;

        return $criteria;
    }

}