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



Route::group(['namespace' => 'Api'],function(){
	Route::post('signup','UserController@signup');
	Route::post('login','UserController@login');
	Route::post('create', 'ContentController@create');

	Route::group(['middleware' => 'auth:api'],function(){

		Route::get('showAll','ContentController@index');
		Route::post('showOne','ContentController@showOne');
		Route::post('delete', 'ContentController@delete');
		Route::post('edit', 'ContentController@edit');
	});
});