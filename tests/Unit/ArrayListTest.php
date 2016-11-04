<?php

namespace PhongoDBTest\Unit;


use PhongoDB\ArrayList;
use PhongoDBTest\Faked\Factory;

class ArrayListTest extends \PHPUnit_Framework_TestCase
{

    public function testAddArrayItem()
    {
        $noTypeArrayList = new ArrayList();
        $this->assertTrue($noTypeArrayList->add(false));
        $this->assertTrue($noTypeArrayList->add('string'));
        $this->assertTrue($noTypeArrayList->add(1));
        $this->assertTrue($noTypeArrayList->add(1.91));
        $this->assertTrue($noTypeArrayList->add(['a', 'r', 'r', 'a', 'y']));

        $m = Factory::random('model');
        $classTypeArrayList = new ArrayList($m);
        $this->assertFalse($classTypeArrayList->add('testing'));
        $this->assertTrue($classTypeArrayList->add($m));

        $stringTypeArrayList = new ArrayList('string');
        $this->assertFalse($stringTypeArrayList->add(1));
        $this->assertTrue($stringTypeArrayList->add('1'));

        $integerTypeArrayList = new ArrayList('integer');
        $this->assertFalse($integerTypeArrayList->add('100'));
        $this->assertTrue($integerTypeArrayList->add(100));
    }

    public function testGetArrayITems()
    {
        $arrayList = new ArrayList('string');
        $arrayList->add('Array', 'List', 'Testing');

        $this->assertEquals($arrayList[0], 'Array');
        $this->assertEquals($arrayList->getItem(1), 'List');
        $this->assertEquals($arrayList->length(), 3);
        $this->assertInternalType('array', $arrayList->all());
    }

    public function testArrayListIndexesManipulation()
    {
        $arrayList = new ArrayList('string');
        $arrayList->add('Uma', 'frase', 'de', 'efeito', 'qualquer');
        $arrayList->remove(1);
        $this->assertEquals($arrayList->length(), 4);

        $arrayList->set(22, 'Xarpir');
        $this->assertEquals($arrayList[22], $arrayList->getItem(22));
        $this->assertEquals($arrayList->length(), 5);
    }

}