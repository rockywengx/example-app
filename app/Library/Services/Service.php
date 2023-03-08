<?php

namespace App\Library\Services;

use App\Library\Models\Repositories\Repository;
use App\Library\Services\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Summary of Service
 */
abstract class Service implements ServiceInterface{
    /**
     * Summary of repo
     * @var
     */
    protected Repository $repo;
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
    abstract public function validateArray():array;
    /**
     * Summary of judgeArray
     * @return array
     */
    abstract public function judgeArray():array;

    /**
     * Summary of __construct
     * @param Repository $repository
     */
    public function __construct(Repository $repository){
        $this->repo = $repository;
        $this->validate = $this->validateArray();
        $this->judges = $this->judgeArray();
    }

    /**
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show(): Collection{
        $result = $this->repo->get();
        return $result;
    }



    public function find($id): array{
        $result = $this->repo->getById($id);
        return $result->toArray();
    }


    public function findFirst(string| null $modelField = null, mixed $value = null): array{
        $result = $this->repo->getFirst($modelField, $value);
        return $result->toArray();
    }


    /**
     * Summary of store
     * @param Request $data
     * @return array
     */
    public function store(Request $data): array{
        $val = $data->validate($this->validate);
        $result = $this->repo->create($val);
        // recordStore那來的不知道
        // $result->recordStore();
        return $result->toArray();
    }

    /**
     * Summary of edit
     * @param int $id
     * @param Request $data
     * @return array<string>
     */
    public function edit(int $id, Request $data): array{
        foreach($this->judges as $judge){
            $this->validate[$judge] .= ','.$id;
        }
        $val = $data->validate($this->validate);
        $material = $this->repo->getById($id);
        $this->repo->update($id,$val);

        // $material->recordEdit();
        return $material->toArray();
    }

    /**
     * Summary of remove
     * @param mixed $id
     * @return void
     */
    public function remove(int $id): bool{
        return $this->repo->delete($id);
    }

}
