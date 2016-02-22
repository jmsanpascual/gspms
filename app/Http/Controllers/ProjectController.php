<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
class ProjectController extends Controller
{

    public function index()
    {
        $status = FALSE;
        $msg = '';
        $data = array();

        try
        {
            $proj = (new App\Projects)->getTable();
            $stat = (new App\ProjectStatus)->getTable();
            Log::info('line 24 - - - -');
            Log::info($proj);
            $data['proj'] = App\Projects::JoinStatus()
                        ->select($proj . '.name',  $proj . '.start_date', $proj . '.end_date', 
                            $stat . '.name AS status', 'total_budget')
                        ->get();
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

    public function create()
    {
        return view('create-project');
    }

    public function show()
    {
        $data['action'] = 'Add';
        return view('modals/projects', $data);
    }

    // public function index()
    // {
    //     try {
    //         $project = App\Project::all();
    //         return Response::json($project);
    //     } catch (Exception $e) {
    //         return Response::json(array('error' => $e->getMessage()));
    //     }
    // }
    
    

    public function store(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {
            $project = $request->all();
            Log::info('project');
            Log::info($project);
            $project['id'] = App\Project::insertGetId($project);
            $data['proj'] = $project;
            $status = TRUE;
       } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

    public function update(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            // $request
            
            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }
}
