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




Route::group(['middleware' => 'web'], function () {
  
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
Route::resource('roles', 'RoleController');
// RESTful resource route for Projects
Route::get('projects/view-project', array('as' => 'view.project', function () {
    return view('view-project');
}));
Route::get('projects/view-project2', array('as' => 'view.project2', function () {
  return view('projects');
}));
Route::get('projects/fetch/{id}', 'ProjectController@fetchProj');
Route::post('projects/request/', 'ProjectController@updateStatus');
Route::post('projects/update', 'ProjectController@update');
Route::resource('projects', 'ProjectController');


Route::get('project-activities/details/{proj_id}/{id}', 'ProjectActivitiesController@fetch');
Route::post('project-activities/update', 'ProjectActivitiesController@update');
Route::post('project-activities/request', 'ProjectActivitiesController@updateStatus');
Route::resource('project-activities', 'ProjectActivitiesController');

Route::resource('budget', 'BudgetController');

Route::get('budget-request/add', array(function () {
    return view('modals/budget-request-form');
}));

// RESTful resource route for Resource Persons
Route::get('resource-persons/view-resource-persons', array('as' => 'resource-persons.view', function () {
    return view('resource-persons');
}));
Route::resource('resource-persons', 'ResourcePersonController');

// RESTful resource route for Schools
Route::resource('schools', 'SchoolController');

Route::post('budget-request/request', 'BudgetRequestController@updateStatus');
Route::post('budget-request/update', 'BudgetRequestController@update');
Route::resource('budget-request', 'BudgetRequestController');
Route::resource('budget-request-status', 'BudgetRequestStatusController');

Route::get('items/add', array(function () {
  return view('modals/items-form');
}));
Route::post('items/update', 'ItemController@update');
Route::resource('items', 'ItemController');

Route::get('categories/add', function(){
  return view('modals/items-category');
});
Route::resource('categories', 'CategoryController');

// RESTful resource route for Programs
Route::resource('programs', 'ProgramController');

// RESTful resource route for Project Status
Route::resource('project-status', 'ProjectStatusController');

// RESTful resource route for Activity Status
Route::resource('activity-status', 'ActivityStatusController');

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
