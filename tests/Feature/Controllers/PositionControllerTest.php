<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\PositionController;
use App\Models\Entities\Position;
use App\Basic\Tests\Feature\TestController;

class PositionControllerTest extends TestController
{
    protected PositionController $control;

    public function setUp(): void
    {
        parent::setUp();

        $this->control = app(PositionController::class);
    }

	/**
	 * @return mixed
	 */
	public function route() {
        return 'api/position';
	}

	/**
	 * @return mixed
	 */
	public function insertArray(): array {

        return Position::factory()->makeOne()->toArray();
	}

	/**
	 * @return mixed
	 */
	public function updateArray(array $source): array {

        $fakeData = Position::factory()->makeOne();

        if(is_null($source)){
        } else {
            $fakeData->id = $source['id'];
        }
        return $fakeData->toArray();
	}
}


