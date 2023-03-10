<?php

namespace App\Models\Repositories;

use App\Models\Entities\Code;
use App\Basic\Models\Repositories\KeyRepository;

class CodeRepository extends KeyRepository
{
	/**
	 * @return string
	 */
	public function model(): string {
        return Code::class;
	}
	/**
	 * Summary of keys
	 * @return array|string ex: [0=> keyname1, 1 =>keyname2]
	 */
	public function getKeys(): array {
        return ['name', 'key', 'value'];
	}
}

