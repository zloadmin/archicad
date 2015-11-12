<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['middleware' => 'admin.auth'], function () {

    Route::get('/', 'FilesController@create');

    Route::post('/', 'FilesController@store');

    Route::get('/list', 'FilesController@files_list');

    Route::get('/show/{id}', 'FilesController@show');

    Route::delete('delete_file/{id}', 'FilesController@destroy');
});


Route::group(['middleware' => 'list.auth'], function () {

    Route::get('/json_list', 'FilesController@json_list');

});