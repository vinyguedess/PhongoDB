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

        $m = Factory::random('model');
        $m->name = 'XPTO2';
    }

    public function testRepositoryFindAll()
    {
        $baseRepository = new BaseRepository(Factory::random('Entity'));
        $mCollection = $baseRepository->findAll();
        $this->assertInstanceOf(ArrayList::class, $mCollection);
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

}