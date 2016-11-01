<?php

namespace PhongoDBTest\Unit;


use PhongoDBTest\Faked\Factory;

class ModelTest extends \PHPUnit_Framework_TestCase
{

    public function testModelGetAndSetAttributes()
    {
        $m = Factory::random('Model');
        $attributes = $m->getAttributes();

        $this->assertArrayHasKey('id', $attributes);

        $attributes['id'] = 2;
        $m->setAttributes($attributes);
        $this->assertEquals($m->id, 2);

        if (isset($attributes['created_at'])) {
            $this->assertInstanceOf('\DateTime', $attributes['created_at']);
        }
    }

}