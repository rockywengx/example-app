<?php

namespace App\Basic\Models\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface KeyRepositoryInterface
{
    public function create(array $data): Model;
    public function updateByKey(array $keyValues, array $data): Model;
    public function deleteByKey(array $keyValues): int;
    public function getByKeys(array $keyValues): Model;
    public function get(array $columns = []): Collection;
    function validateKey(array $keys): void;

    /**
     * Summary of getFirst
     * @param string $modelField
     * @param object $value
     * @return Model
     */
    public function getFirst(string $modelField = null, mixed $value = null): Model;

    /**
     * Summary of getByField
     * @param string $modelField
     * @param object $value
     * @return Model
     */
    public function getByField(string $modelField, mixed $value): Model;

    /**
     * Summary of getlast
     * @return Model
     */
    public function getlast(): Model;

    /**
     * Summary of judgeRepeat
     * @param string $modelField
     * @param string $name
     * @return bool
     */
    public function judgeRepeat(string $modelField, string $name): bool;

    /**
     * Summary of judgeUpdateRepeat
     * @param string $modelField
     * @param string $name
     * @param array $keyValues
     * @return bool
     */
    public function judgeUpdateRepeat(string $modelField, string $name, array $keyValues): bool;

    /**
     * Summary of judgeRepeatBatch
     * @param array $judgeArray
     * @param array $keyValues
     * @return bool
     */
    public function judgeRepeatBatch(array $judgeArray, array $keyValues = []): bool;


    public function paginate(array $columns = [], int $page = 1, int $perPage = 50): LengthAwarePaginator;
}
