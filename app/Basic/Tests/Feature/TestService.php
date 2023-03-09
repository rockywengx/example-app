<?php

namespace App\Basic\Tests\Feature;

use App\Basic\Services\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Exception;

/**
 * Summary of TestService
 */
abstract class TestService extends TestCase
{

    /**
     * Summary of service
     * @return Service
     */
    abstract function service(): Service;

    abstract function insertModel(): Model;

    abstract function updateModel(array $source): Model;

    protected $route;

    protected array $testModel;

    public function testStore()
    {
        $post = $this->insertModel();
        $this->assertNotEmpty($post);

        $request = Request::create('', 'POST', $post->toArray());

        $data = $this->service()->store($request);
        $this->assertNotEmpty($data);
        $this->testModel = $data;
    }



    public function testFind()
    {
        if(isset($this->testModel) && array_key_exists('id', $this->testModel)){
            $id = $this->testModel['id'];
        } else {
            $this->testModel = $this->service()->findFirst();
            if(array_key_exists('id', $this->testModel)){
                $id = $this->testModel['id'];
            }
        }

        $data = $this->service()->find($id);
        $this->assertNotEmpty($data);
    }


    public function testEdit()
    {
        if(!isset($this->testModel)){
            $post = $this->insertModel();
            $request = Request::create('', 'POST', $post->toArray());
            $data = $this->service()->store($request);
            $this->testModel = $data;
        }

        $put = $this->updateModel($this->testModel);
        $this->assertNotEmpty($put);

        $this->assertNotEmpty($this->testModel['id']);
        $request = Request::create('', 'PUT', $post->toArray());

        $data = $this->service()->edit($this->testModel['id'], $request);
        $this->assertNotEmpty($data);
        $this->testModel = $data;
    }


    public function testShow()
    {
        $data = $this->service()->show();
        $this->assertNotEmpty($data);
        $this->assertNotCount(0, $data->items());
        $this->assertNotEmpty($data->currentPage());
    }


    public function testRemove()
    {

        if(!isset($this->testModel)){
            $post = $this->insertModel();
            $request = Request::create('', 'POST', $post->toArray());
            $data = $this->service()->store($request);
            $this->testModel = $data;
        }

        $delete = $this->testModel;
        try{
            $this->service()->remove($delete['id']);
            $this->assertTrue(true);
        } catch(Exception $e){
            $this->assertTrue(false);
        }
    }

}


