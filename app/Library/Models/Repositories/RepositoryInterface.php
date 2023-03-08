<?php

namespace App\Library\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface{
    public function getById(int $id): Model;
    public function getByIdW(int $id): Model;
    public function get(array $list): Collection;
    public function getFirst(string|null $modelField = null, mixed $value = null): Model;
    public function getByField(string $modelField,object $value): Model;
    public function create(array $data): Model;
    public function update(int $id,array $data): Model;
    public function delete(int $id): bool;
    public function judgeRepeat(string $modelField,string $name): bool;
    public function judgeUpdateRepeat(string $modelField,string $name,int $id): bool;
    public function getlast(): Model;
    public function judgeRepeatBatch(array $judgeArray,$id): bool;
}
