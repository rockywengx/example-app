<?php

namespace App\Services;

use App\Models\Repositories\UserRepository;
use App\Library\Services\Service;
use Illuminate\Validation\Rule;

class UserService extends Service{

    public function __construct(UserRepository $userRepository)
    {
        Parent::__construct($userRepository);
    }

	/**
	 * @return array
	 */
	public function validateArray(): array {

        $today = date('Y-m-d');

        return array(
            'name' => 'required|string|unique:username',
            'username' => 'required|string|unique:username',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['string', 'regex:/^[0-9]{10}$/'],
            'address' => 'required|string',
            'birthday' => [
                'required',
                'date',
                Rule::before($today),
            ],
            'status_id' => 'required|int',
            'telephone' => 'required|string',
            'mail' => 'mail',
            'point' => 'required|integer|min:0',
            'sex' => 'required|integer|in:0,1,2',
            'line' => 'required|string',
            'login_branch' => 'required|string'
        );
	}

	/**
	 * @return array
	 */
	public function judgeArray(): array {
        return array('username');
	}
}
