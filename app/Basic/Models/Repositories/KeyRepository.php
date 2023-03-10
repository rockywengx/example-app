<?php

namespace App\Basic\Models\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Summary of KeyRepository
 * 支援單key與複數key
 */
abstract class KeyRepository implements KeyRepositoryInterface
{
    /**
     * Summary of model
     * @var Model
     */
    protected Model $model;

    /**
     * Summary of keys
     * @var array
     * ex: [0=> keyname1, 1 =>keyname2]
     */
    protected array $keys;

    /**
	 * Summary of keys
	 * @return array|string
     * ex: [0=> keyname1, 1 =>keyname2]
	 */
	abstract public function getKeys(): array;

    abstract public function model(): string;

    /**
     * Summary of __construct
     * @param Model $model
     * @param array $keys
     */
    public function __construct()
    {
        $this->model = app($this->model());
        $this->keys = $this->getKeys();
    }

	public function getKeyValues(array $data): array
    {
        $item = [];
        foreach($data as $key => $value){
            if(in_array($key, $this->getKeys()))
            {
                $item[$key] = $value;
            }
        }
        return $item;
    }



    /**
     * Summary of create
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Summary of updateByKey
     * @param array $keyValues
     * @param array $data
     * @throws Exception
     * @return Model
     */
    public function updateByKey(array $keyValues, array $data): Model
    {
        $record = $this->getByKeys($keyValues);
        $count = $record->update($data);
        if ($count > 1 || $count == 0) {
            throw new Exception('異動失敗');
        }
        return $this->getByKeys($keyValues);
    }

    /**
     * Summary of deleteByKey
     * @param array $keys
     * @return int
     */
    public function deleteByKey(array $keyValues): int
    {
        $record = $this->getByKeys($keyValues);
        return $record->delete();
    }

    /**
     * Summary of getByKeys
     * @param array $keys
     * @return Model
     */
    public function getByKeys(array $keyValues): Model
    {
        $this->validateKey($keyValues);

        $query = $this->model->newQuery();

        foreach ($keyValues as $key => $value) {
            $query->where($key, $value);
        }

        return $query->firstOrFail();
    }

    /**
     * Summary of get
     * @param array $columns
     * @return Collection
     */
    public function get(array $columns = []): Collection
    {
        if (count($columns) == 0) {
            return $this->model->all();
        }
        return $this->model->all($columns);
    }


    /**
     * Summary of validateKey
     * @param array $keys
     * @throws Exception
     * @return void
     */
    function validateKey(array $keys): void
    {
        $difference = array_diff($this->keys, array_values($keys));

        if (empty($difference)) {
        } else {
            //return false;
            throw new Exception("傳入的pkey與設定不同");
        }
    }

    /**
     * Summary of getFirst
     * @param string $modelField
     * @param object $value
     * @return Model
     */
    public function getFirst(string $modelField = null, mixed $value = null): Model
    {
        if (!is_null($modelField)) {
            return $this->model->where($modelField, $value)->first();
        }
        return $this->model->first();
    }


    /**
     * Summary of getByField
     * @param string $modelField
     * @param object $value
     * @return Model
     */
    public function getByField(string $modelField, mixed $value): Model
    {
        return $this->model->where($modelField, $value)->get();
    }

    /**
     * Summary of getlast
     * @return Model
     */
    public function getlast(): Model
    {
        // fixe me
        return $this->model->latest('id')->first();
    }

    /**
     * Summary of judgeRepeat
     * @param string $modelField
     * @param string $name
     * @return bool
     */
    public function judgeRepeat(string $modelField, string $name): bool
    {
        $judege = $this->model
            ->where($modelField, $name)
            ->first();
        return is_null($judege);
    }

    /**
     * Summary of judgeUpdateRepeat
     * @param string $modelField
     * @param string $name
     * @param array $keyValues
     * @return bool
     */
    public function judgeUpdateRepeat(string $modelField, string $name, array $keyValues): bool
    {
        // $judege = $this->model
        //     ->where($modelField, $name)
        //     ->where('id', '!=', $id)
        //     ->first();

        $judege = $this->getByKeys($keyValues)
                    ->where($modelField, $name)
                    ->first();
        return is_null($judege);
    }

    /**
     * Summary of judgeRepeatBatch
     * @param array $judgeArray
     * @param array $keys
     * @return bool
     */
    public function judgeRepeatBatch(array $judgeArray, array $keyValues = []): bool
    {
        $model = (count($keyValues) == 0) ? $this->model : $this->getByKeys($keyValues);
        $model = $model->where(function ($query) use ($judgeArray) {
            foreach ($judgeArray as $index => $item) {
                if ($index == 0) {
                    $query->where($item[0], $item[1]);
                } else {
                    $query->orWhere($item[0], $item[1]);
                }
            }
        });
        return $model->first();
    }


    /**
     * Summary of paginate
     * @param array $columns
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $columns = [], int $page = 1, int $perPage = 50): LengthAwarePaginator
    {
        $skip = ($page - 1) * $perPage; // 要跳過的紀錄數量

        if (count($columns) == 0) {
            $builder = $this->model->select();
        } else {
            $builder = $this->model->select($columns);
        }
        if ($skip > 0) {
            $data = $builder->skip($skip)->paginate($perPage);
        } else {
            $data = $builder->paginate($perPage);
        }

        return $data;
    }


}
