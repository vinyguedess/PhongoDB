<?php

namespace PhongoDB\DB;

class Connection extends \MongoClient
{

    public static function getInstance() {
        return new self("mongodb://localhost:27017/phongo_testing");
    }

}