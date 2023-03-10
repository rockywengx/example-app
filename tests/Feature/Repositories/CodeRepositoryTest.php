<?php

namespace Tests\Feature\Repositories;

use App\Basic\Tests\Feature\TestRepository;
use App\Models\Entities\Position;
use App\Models\Repositories\CodeRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class CodeRepositoryTest extends TestRepository
{
    protected CodeRepository $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = app(CodeRepository::class);
    }

	/**
	 * Summary of service
	 * @return \App\Basic\Models\Repositories\Repository
	 */
	public function repository(): \App\Basic\Models\Repositories\Repository {
        return $this->repo;
	}

	/**
	 * @return mixed
	 */
	public function insertModel(): Model {
        return Position::factory()->makeOne();
	}

	/**
	 * @return mixed
	 */
	public function updateModel(Model $source = null) : Model{
        $fakeData = Position::factory()->makeOne();

        if(is_null($source)){
        } else {
            $fakeData->id = $source->id;
        }
        return $fakeData;
	}


}


