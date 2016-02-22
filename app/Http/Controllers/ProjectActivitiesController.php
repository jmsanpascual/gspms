<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Log;
use Lang;
use Response;

class ProjectActivitiesController extends Controller
{
    //

    public function index(Request $request)
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		Log::info('line 24 - - -  PROJACT');
    		Log::info($request->all());
    		$proj_id = $request->get('proj_id');
    		Log::info($request->get('proj_id'));
    		$data['proj_activities'] = App\ProjectActivities::joinActivities()
    									->where('proj_id', $proj_id);
    		$status = TRUE;
    	}
    	catch(Exception $e)
    	{
    		$msg = $e->getMessage();
    	}
    	$data['status'] = $status;
    	$data['msg'] = $msg;

    	return array($data);
    }

    public function show()
    {
        return view('modals/project-activities');
    }

}
