<?php

namespace PhongoDBTest\Unit;

use PhongoDB\ArrayList;
use PhongoDBTest\Faked\Factory;

class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{

    public function testValidations()
    {
        $m = Factory::random('model');
        $this->assertFalse($m->validate());

        $m->name = "asljkdnaslkdnas";
        $this->assertTrue($m->validate());
    }

    public function testModelSaveFindAndUpdate()
    {
        $m = Factory::random('model');
        $m->name = $name = date("YmdHis");
        $m->created_at = (new \DateTime);
        $this->assertTrue($m->save());

        $m->name .= "XPG";
        $this->assertTrue($m->save());
        $this->assertNotEquals($m->name, $name);

        $foundModel = $m->find($m->id);
        $this->assertEquals($foundModel->id, $m->id);

        $this->assertTrue($m->delete());
        $this->assertTrue($m->isNewRecord());
    }

}
