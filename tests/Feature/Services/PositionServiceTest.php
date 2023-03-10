<?php

namespace Tests\Feature\Services;

use App\Basic\Tests\Feature\TestService;
use App\Models\Entities\Position;
use App\Services\PositionService;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class PositionServiceTest extends TestService
{
    protected PositionService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(PositionService::class);
    }

	/**
	 * Summary of service
	 * @return \App\Basic\Services\Service
	 */
	public function service(): \App\Basic\Services\Service {
        return $this->service;
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
	public function updateModel(array $source): Model {

        $fakeData = Position::factory()->makeOne();

        if(is_null($source)){
        } else {
            $fakeData->id = $source['id'];
        }
        return $fakeData;
	}
}


