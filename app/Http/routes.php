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

Route::get('allocate-budget.project', array('as' => 'allocate-budget.project', function () {
  return view('allocate-budget-project');
}));

Route::post('/login', 'UserController@login');
Route::get('/users', 'UserController@index');
Route::get('/fetchUsers', 'UserController@retrieve');

Route::get('addUser', 'UserController@showModal');
Route::post('addUser', 'UserController@create');

Route::get('getRoles', 'UserController@getRoles');
Route::get('showUserDetails', 'UserController@getRoles');

Route::get('user/getChampion', 'UserController@getChampion');
Route::get('user/getResourcePerson', 'UserController@getResourcePerson');
Route::resource('user', 'UserController');
// RESTful resource route for Projects
Route::get('projects/view-project', array('as' => 'view.project', function () {
  return view('view-project');
}));
Route::get('projects/view-project2', array('as' => 'view.project2', function () {
  return view('projects');
}));

Route::post('projects/update', 'ProjectController@update');
Route::resource('projects', 'ProjectController');

Route::resource('project-activities', 'ProjectActivitiesController');

// RESTful resource route for Programs
Route::resource('programs', 'ProgramController');

// RESTful resource route for Project Status
Route::resource('project-status', 'ProjectStatusController');

Route::group(['middleware' => 'web'], function () {
    Route::get('showUserDetails/{id}', 'UserController@retrieveUser');
    Route::post('editUser', 'UserController@update');
    Route::delete('deleteUser/{id}', 'UserController@delete');
});



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
