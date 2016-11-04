<?php

namespace PhongoDBTest\Faked\Entity;


use PhongoDB\DB\ActiveRecord\Model;
use PhongoDB\Interfaces\IEntityInterface;

class User_20161104164121 extends Model implements IEntityInterface
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