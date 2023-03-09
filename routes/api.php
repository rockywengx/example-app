<?php

use App\Http\Controllers\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Basic\Http\Controllers\Middleware\DBTransaction;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PositionController::class)->group(function () {
    Route::get('/position/{id}', 'find');
    Route::get('/position', 'get');
    //add transation
    Route::group(['middleware' => DBTransaction::class], function () {
        // Your routes here
        Route::post('/position', 'new');
        Route::put('/position', 'edit');
        Route::delete('/position', 'delete');
    });
});


