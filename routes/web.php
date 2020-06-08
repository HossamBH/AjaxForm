<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['namespace' => 'Web'], function(){

	Route::get('create', 'ContentController@create');
	Route::post('store', 'ContentController@store')->name('content.store');

	Route::group(['middleware' => ['auth']], function(){

		Route::get('all', 'ContentController@index')->name('content.all');
		Route::get('search', 'ContentController@search')->name('content.search');
		Route::post('delete', 'ContentController@delete')->name('content.delete');
		Route::get('edit/{row_id}', 'ContentController@edit')->name('content.edit');
		Route::post('update', 'ContentController@update')->name('content.update');
	});
});

