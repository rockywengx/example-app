<?php

namespace App\Models\Repositories;

use App\Basic\Models\Repositories\Repository;

use App\Models\Entities\User;

class UserRepository extends Repository
{
	/**
	 * @return string
	 */
	public function model(): string {
        return User::class;
	}
}

