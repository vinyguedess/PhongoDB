<?php

namespace PhongoDBTest\Faked\Model;


class User_20161026162245 extends \PhongoDB\DB\ActiveRecord\ActiveRecord
{

    public $id;
    public $name;
    public $created_at;

    public function getCollection()
    {
        return "user";
    }

}