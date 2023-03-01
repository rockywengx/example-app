<?php
//取的文章列表
Route::get('articles', 'ArticleController@list'); 
//取得文章內容
Route::get('articles/{id}', 'ArticleController@show');
//新增文章 
Route::post('articles', 'ArticleController@store'); 
//更新文章
Route::patch('articles/{id}', 'ArticleController@update');
//刪除文章
Route::delete('articles/{id}', 'ArticleController@destroy');