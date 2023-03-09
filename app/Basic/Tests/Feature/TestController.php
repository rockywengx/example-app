<?php

namespace App\Basic\Tests\Feature;

use Tests\TestCase;

abstract class TestController extends TestCase
{

    abstract function route();

    abstract function insertArray(): array;

    abstract function updateArray(array $source): array;

    protected array $testArray;

    public function testNew()
    {
        $response = $this->post($this->route(), $this->insertArray());
        $response->assertStatus(200);

        $data = $response->json();
        $this->testArray = $data;
    }

    public function testFind()
    {
        $route = $this->route();
        if(isset($this->testArray)){
            $route = $route . '/' . $this->testArray['id'];
        } else {
            $route = $route . '/' . '2';
        }

        $response = $this->get($route);

        $response->assertStatus(200);
    }


    public function testEdit()
    {
        if(!isset($this->testArray)){
            $response = $this->post($this->route(), $this->insertArray());
            $response->assertStatus(200);
            $this->testArray = $response->json();
        }

        $put = $this->updateArray($this->testArray);
        $put['id'] = $this->testArray['id'];
        $response = $this->put($this->route(), $put);
        $response->assertStatus(200);
        $this->testArray = $response->json();
    }


    public function testShow()
    {
        $response = $this->get($this->route());
        $response->assertStatus(200);
    }


    public function testDelete()
    {
        if(!isset($this->testArray)){
            $response = $this->post($this->route(), $this->insertArray());
            $response->assertStatus(200);
            $this->testArray = $response->json();
        }

        $delete = $this->testArray;
        $response = $this->delete($this->route(), $delete);

        $response->assertStatus(200);
    }

}


