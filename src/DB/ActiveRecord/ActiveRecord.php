<?php

namespace PhongoDB\DB\ActiveRecord;


use PhongoDB\DB\Connection;
use PhongoDB\Interfaces\IEntityInterface;

abstract class ActiveRecord extends Model implements IEntityInterface
{

    public function __construct()
    {
        parent::__construct();

        if (!in_array('getCollection', $this->_methods))
            throw new \Exception('Método "getCollection" não encontrado');
    }

    public function isNewRecord()
    {
        return empty($this->id);
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate())
            return false;

        $oData = $this->getJSONified();
        if ($this->isNewRecord())
            return $this->create($oData);

        return $this->update($oData);
    }

    public function create($oData)
    {
        $c = Connection::getCollection($this->getCollection());

        unset($oData['id']);

        $response = $c->insert($oData);
        $this->setAttributes(['id' => $oData['_id']]);

        return is_null($response['err']);
    }

    public function update($oData)
    {
        $c = Connection::getCollection($this->getCollection());

        $id = $oData['id'];
        unset($oData['id']);

        $response = $c->update(['_id' => $id instanceof \MongoId ? $id : new \MongoId($id)], $oData);

        return is_null($response['err']);
    }

    public function find($id = null)
    {
        $collection = Connection::getCollection($this->getCollection());

        $oData = $collection->findOne([
            '_id' => $id instanceof MongoId ? $id : new \MongoId($id)
        ]);
        if (is_null($oData))
            return $oData;

        $cloneModel = new static();
        $cloneModel->setAttributes($oData);

        return $cloneModel;
    }

    public function first()
    {
        $collection = Connection::getCollection($this->getCollection());

        $oData = $collection->findOne();
        if (is_null($oData))
            return $oData;

        $cloneModel = new static();
        $cloneModel->setAttributes($oData);

        return $cloneModel;
    }

    public function delete()
    {
        $collection = Connection::getCollection($this->getCollection());

        $id = $this->id;
        if (!($id instanceof \MongoId))
            $id = new \MongoId($id);

        $response = $collection->remove(['_id' => $id]);
        if ((int) $response['ok'] === 1) {
            $this->id = null;
            return true;
        }

        return false;
    }

}