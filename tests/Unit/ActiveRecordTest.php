<?php

namespace PhongoDBTest\Unit;


use PhongoDBTest\Faked\Factory;

class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{

    public function testFindFirstResult()
    {
        $m = Factory::random('model');
        $this->assertSame($m, $m->find());

        $this->assertNull($m->find(1238120938102831209831209830192839012));
    }

}
