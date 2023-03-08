<?php

namespace App\Models\Repositories;

use App\Models\Entities\Position;
use App\Library\Models\Repositories\Repository;

class PositionRepository extends Repository
{
	/**
	 * @return string
	 */
	public function model(): string {
        return Position::class;
	}
}

