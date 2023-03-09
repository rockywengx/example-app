<?php

namespace App\Basic\Http\Controllers\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class DBTransaction
{
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        try {
            $response = $next($request);
            DB::commit();
            return $response;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
