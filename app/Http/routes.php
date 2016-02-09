<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('index', function () {
  return view('layouts/index');
});

Route::get('create.account', array('as' => 'create.account', function () {
  return view('create-account');
}));

Route::get('create.project', array('as' => 'create.project', function () {
  return view('create-project');
}));

Route::get('allocate-budget.project', array('as' => 'allocate-budget.project', function () {
  return view('allocate-budget-project');
}));

Route::get('/users', 'UserController@index');
Route::get('/fetchUsers', 'UserController@retrieve');

Route::get('addUser', 'UserController@showModal');
Route::post('addUser', 'UserController@create');

Route::get('getRoles', 'UserController@getRoles');
Route::get('showUserDetails', 'UserController@getRoles');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
