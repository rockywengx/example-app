# DBTransaction 執行緒處理
建議：區部
```
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
```

# LogRequests  記錄請求
建議：全域
```
// from App/Http/Kernel.php
protected $middleware = [
    ....
    // 全域加入log
    \App\Http\Middleware\LogRequests::class,
];

```
