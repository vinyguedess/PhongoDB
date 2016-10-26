<?php

namespace PhongoDB\DB\ActiveRecord;


abstract class ActiveRecord extends Model
{

    public function __construct()
    {
        parent::__construct();

        if (!in_array('getCollection', $this->_methods))
            throw new \Exception('Método "getCollection" não encontrado');
    }

    public function find($id)
    {

    }

}