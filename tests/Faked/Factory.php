<?php

namespace PhongoDBTest\Faked;


use PhongoDB\DB\ActiveRecord\ActiveRecord;
use PhongoDBTest\Faked\Model\User_20161026162245;

class Factory
{

    /**
     * @param string $type
     * @return mixed
     */
    public static function random($type)
    {
        $type = ucfirst(strtolower($type));
        if (!is_dir(__DIR__ . "/{$type}"))
            return false;

        $files = glob(__DIR__ . "/{$type}/*.php");
        $file = "PhongoDBTest\\Faked\\" . str_replace([
            __DIR__ . "/", "/", ".php"
        ], ["", "\\", ""], $files[array_rand($files)]);

        return new $file;
    }

}