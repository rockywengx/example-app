<?php

namespace App\Models\Repositories;

use App\Basic\Models\Repositories\Repository;

use App\Models\Entities\Usercode;

class UserecodeRepository extends Repository
{
	/**
	 * @return string
	 */
	public function model(): string {
        return Usercode::class;
	}
}

