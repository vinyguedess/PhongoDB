<?php

namespace PhongoDBTest\Unit;


use PhongoDB\ArrayList;
use PhongoDB\DB\Criteria;
use PhongoDB\DB\Repository\BaseRepository;
use PhongoDBTest\Faked\Factory;

class BaseRepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $m = Factory::random('model');
        $m->name = "XPTO1";
        $m->save();

        $m = Factory::random('model');
        $m->name = 'XPTO2';
        $m->save();
    }

    public function testRepositoryFindAndSearch()
    {
        $baseRepository = new BaseRepository(Factory::random('Entity'));
        $mArrayList = $baseRepository->findAll();
        $this->assertInstanceOf(ArrayList::class, $mArrayList);
        $this->assertGreaterThanOrEqual(2, $mArrayList->length());

        $criteria = new Criteria;
        $criteria->where('name', 'XPTO1');
        $mArrayList = $baseRepository->findAll($criteria);
        $this->assertEquals(1, $mArrayList->length());
    }

    public function testRepositorySave()
    {
        $baseRepository = new BaseRepository(Factory::random('Entity'));

        $entity = Factory::random('Entity');
        $entity->name = 'Testing Entity saving';
        $this->assertTrue($baseRepository->save($entity));

        $this->assertNotNull($entity->id);
        $this->assertInstanceOf(\MongoId::class, $entity->id);

        $entity->name = 'HOCUS POCUS';
        $this->assertTrue($baseRepository->save($entity));

        $criteria = new Criteria();
        $criteria->where('name', 'HOCUS POCUS');

        $entity = $baseRepository->find($criteria);
        $this->assertEquals('HOCUS POCUS', $entity->name);
    }

    public function testRepositoryDelete()
    {
        $baseRepository = new BaseRepository(Factory::random('model'));
        $this->assertTrue($baseRepository->delete(Factory::random('model')));
    }

    public function tearDown()
    {
        $hasModel = true;
        while ($hasModel) {
            $createdModel = Factory::random('model')->first();
            if (is_null($createdModel))
                break;

            $createdModel->delete();
        }
    }

}