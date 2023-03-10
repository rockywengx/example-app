<?php

namespace App\Basic\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function getById(int $id): Model;
    public function getByIdW(int $id): Model;
    public function get(array $columns): Collection;
    public function count(string $modelField = null, mixed $value = null): int;
    public function getFirst(string $modelField = null, mixed $value = null): Model;
    public function getByField(string $modelField, mixed $value): Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function delete(int $id): bool;
    public function judgeRepeat(string $modelField, string $name): bool;
    public function judgeUpdateRepeat(string $modelField, string $name, int $id): bool;
    public function getlast(): Model;
    public function judgeRepeatBatch(array $judgeArray, $id): bool;
    public function paginate(array $columns, int $page = 1, int $perPage = 50): LengthAwarePaginator;
}
