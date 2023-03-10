<?php

namespace App\Basic\Tests\Feature;

use App\Basic\Models\Repositories\KeyRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Exception;

/**
 * Summary of TestService
 */
abstract class TestKeyRepository extends TestCase
{

    /**
     * Summary of service
     * @return KeyRepository
     */
    abstract function repository(): KeyRepository;

    abstract function insertModel(): Model;

    abstract function updateModel(Model $source = null): Model;

    protected $route;

    protected Model $testModel;

    public function testGetFirst(): void
    {
        if (isset($this->testModel)) {

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
        $keyValues = $this->repository()->getKeyValues($this->testModel->toArray());
        $this->assertEmpty(array_filter($keyValues, function($value) {
            return empty($value);
        }));
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
        if (isset($this->testModel)) {
            $keyValues = $this->repository()->getKeyValues($this->testModel->toArray());
        } else {
            $this->testModel = $this->repository()->getFirst();
            $keyValues = $this->repository()->getKeyValues($this->testModel->toArray());
        }

        // 檢查任一key不可為空值
        $this->assertEmpty(array_filter($keyValues, function($value) {
            return empty($value);
        }));

        $data = $this->repository()->getByKeys($keyValues);
        $this->assertNotEmpty($data);
    }


    public function testUpdate()
    {

        if (!isset($this->testModel)) {
            $post = $this->insertModel();
            $data = $this->repository()->create($post->toArray());
            $this->testModel = $data;
        }

        $put = $this->updateModel($this->testModel);
        $this->assertNotEmpty($put);

        $keyValues = $this->repository()->getKeyValues($this->testModel->toArray());

        // 檢查任一key不可為空值
        $this->assertEmpty(array_filter($keyValues, function($value) {
            return empty($value);
        }));

        $putArray = $put->toArray();
        array_replace($putArray, $keyValues);

        $data = $this->repository()->updateByKey($keyValues, $putArray);
        $this->assertNotEmpty($data);
        $this->testModel = $data;
    }

    public function testDelete()
    {

        if (!isset($this->testModel)) {
            $post = $this->insertModel();
            $data = $this->repository()->create($post->toArray());
            $this->testModel = $data;
        }

        $keyValues = $this->repository()->getKeyValues($this->testModel->toArray());

        // 檢查任一key不可為空值
        $this->assertEmpty(array_filter($keyValues, function($value) {
            return empty($value);
        }));

        try {
            $this->repository()->deleteByKey($keyValues);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testPaginate(): void
    {
        $data = $this->repository()->paginate();
        $this->assertNotCount(0, $data->items());
        $this->assertNotEmpty($data->currentPage());
    }

}
