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

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/login', 'API\UserController@login');
Route::post('api/register', 'API\UserController@register');

Route::group(['middleware' => ['auth:api','throttle:5,1']], function(){
	Route::post('api/details', 'API\UserController@details');
	Route::post('api/getall', 'API\UserController@getall');
});


// $app->group(['middleware' => 'throttle:60,1'], function () use ($app) {
//     $app->get('/', function () use ($app) {
//         return $app->version();
//     });
// });


// Route::get('user/all', 'UserController@index');
Route::post('api/user/create', 'UserController@createUser');


// Route::get('api/user/all', 'UserController@getUsers');

Route::get('api/user/all', ['middleware' => 'auth:api', 'before' => 'auth:api', 'uses' => 'UserController@getUsers']);