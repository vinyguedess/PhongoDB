<?php

namespace PhongoDBTest\Unit;


use PhongoDBTest\Faked\Factory;

class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{

    public function testModelSaveFindAndUpdate()
    {
        $m = Factory::random('model');
        $m->name = date("YmdHis");
        $m->created_at = (new \DateTime);
        $this->assertTrue($m->save());

        $foundModel = $m->find($m->id);
        $this->assertEquals($foundModel->id, $m->id);
    }

}
