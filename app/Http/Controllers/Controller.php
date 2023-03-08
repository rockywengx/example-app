<?php

namespace App\Http\Controllers;

use App\Library\Http\Controllers\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="Swagger-doc Services API",
 *      version="1.0.0",
 *      description="Swagger Service App",
 *      @OA\Contact(
 *          email="your-email@gmail.com"
 *      )
 *  ),
 *  @OA\Server(
 *      description="Swagger-doc App API",
 *      url="https:/localhost/api/document"
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;
}
