<?php

namespace App\Http\Resources;

use App\Basic\Http\Resources\PaginateResource;
use Illuminate\Http\Request;

class PositionListResource extends PaginateResource
{

	/**
     *
	 * @return array
	 */
	public function data(Request $request, array $items): array {
        $result = [];
        foreach($items as $data){
            array_push($result, new PositionResource($data));
        }
        return $result;
	}
}
