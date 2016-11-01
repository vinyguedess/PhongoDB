<?php

namespace PhongoDB\DB\ActiveRecord;


use PhongoDB\DB\Connection;
use PhongoDB\Interfaces\IActiveRecordInterface;

abstract class ActiveRecord extends Model implements IActiveRecordInterface
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

    public function save()
    {
        $oData = $this->getJSONified();
        if ($this->isNewRecord())
            return $this->create($oData);

        return $this->update($oData);
    }

    public function create($oData)
    {
        $conn = Connection::getInstance();
        $c = new \MongoCollection($conn->selectDB('phongo_testing'), $this->getCollection());

        unset($oData['id']);

        $response = $c->insert($oData);
        $this->setAttributes(['id' => $oData['_id']]);

        return is_null($response['err']);
    }

    public function update()
    {

    }

    public function find($id = null)
    {
        $conn = Connection::getInstance();
        $collection = new \MongoCollection($conn->selectDB('phongo_testing'), $this->getCollection());

        $oData = $collection->findOne([
            '_id' => $id instanceof MongoId ? $id : new \MongoId($id)
        ]);
        if (is_null($oData))
            return $oData;

        $cloneModel = new static();
        $cloneModel->setAttributes($oData);

        return $cloneModel;
    }

}