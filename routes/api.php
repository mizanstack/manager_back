<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => ''], function () {
	Route::get('get-directories', 'Api\DirectoryAPIController@get_directories');

    Route::resource('directories', 'Api\DirectoryAPIController');
    Route::resource('media', 'Api\MediaAPIController');
});
