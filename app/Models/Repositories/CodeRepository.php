<?php

namespace App\Models\Repositories;

use App\Models\Entities\Code;
use App\Basic\Models\Repositories\Repository;

class CodeRepository extends Repository
{
	/**
	 * @return string
	 */
	public function model(): string {
        return Code::class;
	}
}

