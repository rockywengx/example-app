<?php

namespace Tests\Feature\Repositories;

use App\Basic\Models\Repositories\KeyRepository;
use App\Basic\Tests\Feature\TestKeyRepository;
use App\Models\Entities\Code;
use App\Models\Repositories\CodeRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class CodeRepositoryTest extends TestKeyRepository
{
    protected CodeRepository $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = app(CodeRepository::class);
    }

	/**
	 * Summary of service
	 * @return \App\Basic\Models\Repositories\KeyRepository
	 */
	public function repository(): KeyRepository {
        return $this->repo;
	}

	/**
	 * @return mixed
	 */
	public function insertModel(): Model {
        return Code::factory()->makeOne();
	}

	/**
	 * @return mixed
	 */
	public function updateModel(Model $source = null) : Model{
        $fakeData = Code::factory()->makeOne();

        if(is_null($source)){
        } else {
            $fakeData->id = $source->id;
        }
        return $fakeData;
	}


}


