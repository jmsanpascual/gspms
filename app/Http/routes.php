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

Route::group(['middleware' => ['web','session_check']], function () {

Route::get('index', function () {
    return view('welcome');
});

Route::get('create.account', array('as' => 'create.account', function () {
  return view('create-account');
}));

// Route::group(['middleware' => 'web'], function () {

  Route::get('index', function () {
    return view('layouts/index');
  });

Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
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

// RESTful resource route for Funds
Route::get('funds/view', function () {
    return view('funds');
});
Route::get('funds/logs', function () {
    return view('fund-logs');
});
Route::get('funds/school-funds', 'FundController@getSchoolFunds');
Route::resource('funds', 'FundController');

// RESTful resource route for Fund Allocation
Route::get('funds-allocation/view', function () {
  return view('funds-allocation');
});
Route::post('funds-allocation/update', 'FundAllocationController@update');
Route::resource('funds-allocation', 'FundAllocationController');

// RESTful resource route for Projects
Route::get('projects/view-project', array('as' => 'view.project', function () {
    return view('view-project');
}));
Route::get('projects/view-project2', array('as' => 'view.project2', function () {
  return view('projects');
}));

Route::get('projects/view-related', function() {
    return view('modals/project-related');
});

Route::get('projects/compare', function() {
    return view('modals/project-comparison');
});

Route::get('projects/get-on-going-projects', 'ProjectController@getOnGoingProjects');
Route::post('projects/update-total-budget', 'ProjectController@updateTotalBudget');
Route::get('projects/chart/{id}', 'ProjectController@createChart')->name('proj_chart');
Route::get('projects/report/{id}', 'ProjectController@report')->name('proj_report');
Route::get('projects/fetch/{id}', 'ProjectController@fetchProj');
Route::post('projects/request/', 'ProjectController@updateStatus');
Route::post('projects/update', 'ProjectController@update');
Route::get('projects/related/{id}', 'ProjectController@getRelated');
Route::resource('projects', 'ProjectController');


Route::get('project-activities/details/{proj_id}/{id}', 'ProjectActivitiesController@fetch');
Route::post('project-activities/update', 'ProjectActivitiesController@update');
Route::post('project-activities/request', 'ProjectActivitiesController@updateStatus');
Route::resource('project-activities', 'ProjectActivitiesController');

Route::get('add-task-remarks-view', function () {
    return view('modals/task-remarks');
});
Route::post('add-task-remarks', 'ProjectActivitiesController@addTaskRemarks');

Route::resource('budget', 'BudgetController');

Route::get('budget-request/add', array(function () {
    return view('modals/budget-request-form');
}));

// RESTful resource route for Resource Persons
Route::get('resource-persons/view-resource-persons', array('as' => 'resource-persons.view', function () {
    return view('resource-persons');
}));
Route::post('resource-persons/update', 'ResourcePersonController@update');
Route::resource('resource-persons', 'ResourcePersonController');

// RESTful resource route for Schools
Route::resource('schools', 'SchoolController');

Route::post('budget-request/request', 'BudgetRequestController@updateStatus');
Route::post('budget-request/update', 'BudgetRequestController@update');
Route::resource('budget-request', 'BudgetRequestController');
Route::resource('budget-request-status', 'BudgetRequestStatusController');

Route::get('items/getItemCategoryList/{id}', 'ItemController@itemCategoryList');
Route::get('items/names', 'ItemController@getAllItems');
Route::get('items/price-recommendation', 'ItemController@getPriceRecommendation');
Route::get('items/add', array(function () {
  return view('modals/items-form');
}));
Route::post('items/update', 'ItemController@update');
Route::resource('items', 'ItemController');

Route::get('categories/add', function(){
  return view('modals/items-category');
});
Route::resource('categories', 'CategoryController');

// RESTful resource route for Attachments
Route::get('project-attachments/add', array(function () {
  return view('modals/project-attachments-form');
}));
Route::post('project-attachments/find/{id}', 'ProjectAttachmentController@find');
Route::post('project-attachments/update', 'ProjectAttachmentController@update');
Route::get('project-attachments/showFiles/{id}', 'ProjectAttachmentController@showFiles');
Route::delete('project-attachments/deleteFile/{id}', 'ProjectAttachmentController@destroyAttachment');
Route::resource('project-attachments', 'ProjectAttachmentController');

// RESTful resource route for Programs
Route::resource('programs', 'ProgramController');

// RESTful resource route for Project Status
Route::resource('project-status', 'ProjectStatusController');

// RESTful resource route for notifications
Route::get('notifications/projects/{id}/{userNotifId}', 'NotificationController@projects');
Route::get('notifications/lists', 'NotificationController@lists');
Route::get('notifications/getAllNotif', 'NotificationController@getAllNotif');
Route::resource('notifications', 'NotificationController');

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

  Route::post('/login', 'UserController@login');
  Route::get('/', function () {

      if(!Auth::check())
        return view('login');
      else
        return view('welcome');
  });
});
