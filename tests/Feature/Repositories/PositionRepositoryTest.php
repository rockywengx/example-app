<?php

namespace Tests\Feature\Repositories;

use App\Library\Tests\Feature\TestRepository;
use App\Models\Entities\Position;
use App\Models\Repositories\PositionRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class PositionRepositoryTest extends TestRepository
{
    protected PositionRepository $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = app(PositionRepository::class);
    }

	/**
	 * Summary of service
	 * @return \App\Library\Models\Repositories\Repository
	 */
	public function repository(): \App\Library\Models\Repositories\Repository {
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


