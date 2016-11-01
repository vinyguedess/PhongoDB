<?php

namespace PhongoDBTest\Faked\Model;


use PhongoDB\DB\ActiveRecord\ActiveRecord;

class User_20161026162245 extends ActiveRecord
{

    public $id;
    public $name;
    public $created_at;

    public function getCollection()
    {
        return "users";
    }

}