<?php

namespace App\Library\Tests\Feature;

use App\Library\Models\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Exception;

/**
 * Summary of TestService
 */
abstract class TestRepository extends TestCase
{

    /**
     * Summary of service
     * @return Repository
     */
    abstract function repository(): Repository;

    abstract function insertModel(): Model;

    abstract function updateModel(Model $source = null): Model;

    protected $route;

    protected Model $testModel;

    public function testGetFirst(): void
    {
        if(isset($this->testModel)){

        } else {
            $data = $this->repository()->getFirst();
            $this->testModel = $data;
        }

        $attrs = $this->testModel->getAttributes();
        $firstKey = array_key_first($attrs);
        $data = $this->repository()->getFirst($firstKey, $attrs[$firstKey]);

        $this->assertNotEmpty($data);
    }


    public function testCreate()
    {
        $post = $this->insertModel();
        $this->assertNotEmpty($post);

        $data = $this->repository()->create($post->toArray());
        $this->assertNotEmpty($data);
        $this->testModel = $data;
        $id = $this->testModel->id;
        $this->assertNotEmpty($id);
    }

    public function testGetByIdW(): void
    {
        if(isset($this->testModel)){
            $id = $this->testModel->id;
        } else {
            $id = $this->repository()->getFirst()->id;
        }
        $data = $this->repository()->getByIdW($id);
        $this->assertNotEmpty($data);
    }

    public function testGet(): void
    {
        $data = $this->repository()->get();
        $this->assertNotEmpty($data);
    }


    public function testLast(): void
    {
        $data = $this->repository()->getlast();
        $this->assertNotEmpty($data);
    }

    public function testGetById(): void
    {
        if(isset($this->testModel)){
            $id = $this->testModel->id;
        } else {
            $id = $this->repository()->getFirst()->id;
        }
        $data = $this->repository()->getById($id);
        $this->assertNotEmpty($data);
    }


    public function testUpdate()
    {

        if(!isset($this->testModel)){
            $post = $this->insertModel();
            $data = $this->repository()->create($post->toArray());
            $this->testModel = $data;
        }

        $put = $this->updateModel($this->testModel);
        $this->assertNotEmpty($put);

        $this->assertNotEmpty($this->testModel['id']);
        $put->id = $this->testModel['id'];

        $data = $this->repository()->update($this->testModel['id'], $put->toArray());
        $this->assertNotEmpty($data);
        $this->testModel = $data;
    }

    public function testDelete()
    {

        if(!isset($this->testModel)){
            $post = $this->insertModel();
            $data = $this->repository()->create($post->toArray());
            $this->testModel = $data;
        }

        $delete = $this->testModel;
        try{
            $this->repository()->delete($delete['id']);
            $this->assertTrue(true);
        } catch(Exception $e){
            $this->assertTrue(false);
        }
    }

}


