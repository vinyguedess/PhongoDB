<?php

namespace PhongoDBTest\Faked\Model;


use PhongoDB\DB\ActiveRecord\ActiveRecord;

class User_20161026162245 extends ActiveRecord
{

    public $id;

    /**
     * @Type(string)
     * @MaxLength(100)
     * @MinLength(4)
     * @Required(true)
     */
    public $name;

    /**
     * @Type(date)
     * @Required(true)
     * @Default(now)
     */
    public $created_at;

    public function getCollection()
    {
        return "users";
    }

}