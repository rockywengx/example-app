<?php

namespace App\Http\Controllers;

use App\Basic\Http\Controllers\Traits\ApiResponse;
use App\Http\Resources\PositionListResource;
use App\Http\Resources\PositionResource;
use App\Services\PositionService;
use Illuminate\Http\Request;

/**
 * Summary of PositionController
 */
class PositionController extends Controller
{
    /**
     * Summary of service
     * @var
     */
    protected $service;

    /**
     * Summary of __construct
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService)
    {
        $this->service = $positionService;
    }

    /**
     * Summary of get
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request)
    {

        $page = $request->query("page");
        if (is_null($page))
            $page = 1;

        $perPage = $request->query("perPage");
        if (is_null($perPage))
            $perPage = 1;

        $data = $this->service->show([], $page, $perPage);

        if ($data->isEmpty()) {
            return $this->error("查無資料");
        }

        $resource = new PositionListResource($data);
        return $this->success($resource);
    }

    /**
     * Summary of find
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function find(Request $request, string $id)
    {
        $data = $this->service->find($id);
        $resource = new PositionResource($data);

        return $this->success($resource);
    }

    /**
     * Summary of new
     * @param Request $request
     * @return mixed
     */
    public function new (Request $request)
    {
        $data = $this->service->store($request);
        return $this->success(new PositionResource($data));

    }

    /**
     * Summary of edit
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $data = $this->service->edit($request->id, $request);
        return $this->success(new PositionResource($data));
    }

    /**
     * Summary of delete
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $this->service->remove($request->id);
        return $this->success();

    }
}
