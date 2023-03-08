<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Entities\Position;
use App\Services\PositionService;
use Illuminate\Http\Request;
/**
 * Summary of PositionController
 */
class PositionController extends Controller
{
    protected $service;

    /**
     * Summary of __construct
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService) {
        $this->service = $positionService;
    }

    public function get(){
        $data = $this->service->show();

        if($data->isEmpty()){
            return $this->error("查無資料");
        }

        // return $this->success($data);
        return response()->json($data);
    }

    public function find(Request $request, string $id){
        return $this->service->find($id);
    }

    public function new(Request $request)
    {
        return $this->service->store($request);
    }

    public function edit(Request $request)
    {
        return $this->service->edit($request->id, $request);
    }

    public function delete(Request $request)
    {
        return $this->service->remove($request->id);
    }
}

