<?php

namespace PhongoDB\DB;

class Connection extends \MongoClient
{

    public static function getInstance() {
        return new self("mongodb://localhost:27017");
    }

    public static function getCollection($collection) {
        $conn = self::getInstance();

        return new \MongoCollection($conn->selectDB('phongo_testing'), $collection);
    }

}