<?php

namespace App\Services;

use App\Models\Repositories\PositionRepository;
use App\Library\Services\Service;

class PositionService extends Service{

    protected $request;

    public function __construct(PositionRepository $positionRepository)
    {
        Parent::__construct($positionRepository);
    }

	/**
	 * @return array
	 */
	public function validateArray(): array {

        // return $this->request->rules();
        return [
            'name' => 'required|string|unique:position,name',
        ];
	}

	/**
	 * @return array
	 */
	public function judgeArray(): array {
        return array('name');
	}
}
