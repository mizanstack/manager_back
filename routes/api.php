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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('logout', 'Api\AuthController@logout');

Route::get('open', 'Api\AuthController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('closed', 'Api\AuthController@closed');
    Route::get('me', 'Api\AuthController@me');
});


Route::group(['prefix' => '', 'middleware' => ['jwt.verify']], function () {
	Route::get('get-directories', 'Api\DirectoryAPIController@get_directories');
	Route::get('open-directory/{id}', 'Api\DirectoryAPIController@open_directory');

	// folder named as directory
	Route::post('save-folder', 'Api\DirectoryAPIController@save_folder');
	Route::post('update-folder/{id}', 'Api\DirectoryAPIController@update_folder');
	Route::post('delete-folder/{id}', 'Api\DirectoryAPIController@destroy');


	Route::post('upload-files', 'Api\MediaAPIController@upload_files');

    // Route::resource('directories', 'Api\DirectoryAPIController');
    // Route::resource('media', 'Api\MediaAPIController');
});


Route::get('nested-directories', 'Api\DirectoryAPIController@nested_directories');


Route::get('copy-folder/{id}/{paste_id?}', 'Api\DirectoryAPIController@copy_folder');
Route::get('cut-folder/{id}/{paste_id?}', 'Api\DirectoryAPIController@cut_folder');

Route::get('copy-media/{id}/{paste_id?}', 'Api\DirectoryAPIController@copy_media');
Route::get('cut-media/{id}/{paste_id?}', 'Api\DirectoryAPIController@cut_media');
