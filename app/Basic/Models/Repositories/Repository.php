<?php

namespace App\Basic\Models\Repositories;

use App\Basic\Models\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Summary of Repository
 */
abstract class Repository implements RepositoryInterface
{

    /**
     * Summary of model
     * @var Model
     */
    protected Model $model;

    /**
     * Summary of model
     * @return string
     */
    abstract public function model(): string;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->model = app($this->model());
    }

    /**
     * Summary of getById
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Summary of getByIdW
     * @param int $id
     * @return Model
     */
    public function getByIdW(int $id): Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function count(string $modelField = null, mixed $value = null): int
    {
        return $this->model->count($modelField, $value);
    }

    /**
     * Summary of get
     * @param array $list
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
        return $this->model->latest('id')->first();
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
     * Summary of update
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Summary of delete
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Summary of judgeRepeat
     * @param string $modelField
     * @param string $name
     * @return bool
     */
    public function judgeRepeat(string $modelField, string $name): bool
    {
        $judege = $this->model->where($modelField, $name)->first();
        return is_null($judege);
    }

    /**
     * Summary of judgeUpdateRepeat
     * @param string $modelField
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function judgeUpdateRepeat(string $modelField, string $name, int $id): bool
    {
        $judege = $this->model
            ->where($modelField, $name)
            ->where('id', '!=', $id)
            ->first();
        return is_null($judege);
    }

    /**
     * Summary of judgeRepeatBatch
     * @param array $judgeArray
     * @param mixed $id
     * @return bool
     */
    public function judgeRepeatBatch(array $judgeArray, $id): bool
    {
        $model = (is_null($id)) ? $this->model : $this->model->where('id', '!=', $id);
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
     * Summary of judgeStoreAlong
     * @param string $storeBranchId
     * @param string $modelField
     * @param string $name
     * @return bool
     */
    public function judgeStoreAlong(string $storeBranchId, string $modelField, string $name): bool
    {
        $judege = $this->model
            ->where('store_branch_id', $storeBranchId)
            ->where($modelField, $name)
            ->first();
        return is_null($judege);
    }

    /**
     * Summary of judgeUpdateStoreAlong
     * @param string $storeBranchId
     * @param string $modelField
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function judgeUpdateStoreAlong(string $storeBranchId, string $modelField, string $name, int $id): bool
    {
        $judege = $this->model
            ->where('id', '!=', $id)
            ->where('store_branch_id', $storeBranchId)
            ->where($modelField, $name)
            ->first();
        return is_null($judege);
    }

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
