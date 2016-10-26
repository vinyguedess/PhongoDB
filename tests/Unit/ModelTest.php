<?php

namespace PhongoDBTest\Unit;


use PhongoDBTest\Faked\Factory;

class ModelTest extends \PHPUnit_Framework_TestCase
{

    public function testModelGetAndSetAttributes()
    {
        $m = Factory::random('Model');

        $this->assertArrayHasKey('id', $m->getAttributes());

        $m->setAttributes(['id' => 2]);
        $this->assertEquals($m->id, 2);
    }

}