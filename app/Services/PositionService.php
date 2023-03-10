<?php

namespace App\Services;

use App\Models\Repositories\PositionRepository;
use App\Basic\Services\Service;
// use App\Models\Repositories\CodeRepository;
use Illuminate\Http\Request;

class PositionService extends Service{


    public function __construct(
        PositionRepository $positionRepository)
    {
        Parent::__construct($positionRepository);
    }

    /**
     * 以下試範多層操作
     */
    /*
    // 選擇一:
    protected CodeRepository $codeRepository;
    // 選擇二:(建議)
    protected CodeService $codeService;

    public function __construct(
        PositionRepository $positionRepository,
        CodeRepository $codeRepository,
        CodeService $codeService)
    {
        Parent::__construct($positionRepository);
        $this->codeRepository = $codeRepository;
        $this->codeService = $codeService;
    }

    // override store function
    public function store(Request $data) : array
    {
        // 選擇一:
        // 使用CodeRepository進行操作 impl Code insert
        // $val = $data->validate($this->validateCode);
        // $result = $this->repo->create($val);
        // $newCode = $this->codeRepository->create($data);

        // 選擇二:(建議)
        // 使用CodeService進行操作
        // $this->codeService->store($data);

        // 呼叫底層 impl Position insert
        return parent::store($data);
    }
    */


	/**
	 * @return array
	 */
	public function validateArray(): array {

        return [
            'name' => 'required|string|unique:position,name',
        ];
	}

	/**
     * 需確認validateArray相對應欄位有加入unique設定
	 * @return array
	 */
	public function judgeArray(): array {
        return array('name');
	}
}
