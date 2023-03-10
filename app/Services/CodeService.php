<?php

namespace App\Services;

use App\Models\Repositories\CodeRepository;
use App\Basic\Services\Service;

class CodeService extends Service
{

    public function __construct(CodeRepository $codeRepository)
    {
        parent::__construct($codeRepository);
    }

    /**
     * @return array
     */
    public function validateArray(): array
    {

        return [
            'name' => 'required|string|unique:codes,name,key,value',
            'key' => 'required|string|unique:codes,name,key,value',
            'value' => 'required|string|unique:codes,name,key,value',
            'value2' => 'required|string|unique:codes,name,key,value',
            'disabled' => 'required|boolean'
        ];
    }

    /**
     * 需確認validateArray相對應欄位有加入unique設定
     * @return array
     */
    public function judgeArray(): array
    {
        return array('value2');
    }
}
