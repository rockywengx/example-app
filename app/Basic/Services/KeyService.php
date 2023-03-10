<?php

namespace App\Basic\Services;

use App\Basic\Models\Repositories\KeyRepository;
use App\Basic\Services\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Summary of Service
 */
abstract class KeyService implements KeyServiceInterface
{
    /**
     * Summary of repo
     * @var
     */
    protected KeyRepository $repo;
    /**
     * Summary of validate
     * @var
     */
    protected $validate;
    /**
     * Summary of judges
     * @var
     */
    protected $judges;

    /**
     * Summary of validateArray
     * @return array
     */
    abstract public function validateArray(): array;
    /**
     * Summary of judgeArray
     * @return array
     */
    abstract public function judgeArray(): array;

    /**
     * Summary of __construct
     * @param KeyRepository $repository
     */
    public function __construct(KeyRepository $repository)
    {
        $this->repo = $repository;
        $this->validate = $this->validateArray();
        $this->judges = $this->judgeArray();
    }


    /**
     * Summary of show
     * @param array $columns
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function show(array $columns = [], int $page = 1, int $perPage = 50): LengthAwarePaginator
    {
        $result = $this->repo->paginate($columns, $page, $perPage);
        return $result;
    }

    /**
     * Summary of find
     * @param array $keyValues
     * @return array
     */
    public function find(array $keyValues): array
    {
        $result = $this->repo->getBykeys($keyValues);
        return $result->toArray();
    }


    /**
     * Summary of findFirst
     * @param string|null $modelField
     * @param mixed|null $value
     * @return array
     */
    public function findFirst(string|null $modelField = null, mixed $value = null): array
    {
        $result = $this->repo->getFirst($modelField, $value);
        return $result->toArray();
    }


    /**
     * Summary of store
     * @param Request $data
     * @return array
     */
    public function store(Request $data): array
    {
        $val = $data->validate($this->validate);
        $result = $this->repo->create($val);
        return $result->toArray();
    }

    /**
     * Summary of edit
     * @param array $keyValues
     * @param Request $data
     * @return array<string>
     */
    public function edit(array $keyValues, Request $data): array
    {
        $exclude = implode(',', $keyValues) . implode(',', array_keys($keyValues));

        foreach($this->judges as $judge){
            $this->validate[$judge] .= ',' . $exclude;
        }
        $val = $data->validate($this->validate);
        $material = $this->repo->getByKeys($keyValues);
        $this->repo->updateByKey($keyValues, $val);

        return $material->toArray();
    }

    /**
     * Summary of remove
     * @param array
     * @return void
     */
    public function remove(array $keyValues): bool
    {
        return $this->repo->deleteByKey($keyValues);
    }

}
