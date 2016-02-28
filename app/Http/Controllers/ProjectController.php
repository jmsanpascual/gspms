<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
use DB;
class ProjectController extends Controller
{

    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

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
                        ->select($proj . '.name', $stat . '.name AS status', $proj . '.id', 
                        'start_date','end_date', 'objective', 'total_budget', 'champion_id', 
                        'program_id', 'proj_status_id', 'resource_person_id', 'partner_organization',
                        'partner_community')
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
        return view('modals/projects');
    }

    public function fetchProj($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::select('id', 'name', 'start_date','end_date', 'objective', 
                'total_budget', 'champion_id', 'program_id', 'proj_status_id', 'resource_person_id',
                'partner_organization', 'partner_community')
            ->where('id', $id)->first();
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
            // get status name
            $stat_name = App\ActivityStatus::where('id', $project['proj_status_id'])->value('name');
            $data['proj'] = $project;
            $data['proj']['status'] = $stat_name;
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
            $request = $request->all();
            Log::info('update');
            Log::info($request);
            $id = $request['id'];
            $upd_arr = $request;
            unset($upd_arr['id']);
            unset($upd_arr['status']);
            App\Projects::where('id', $id)->update($upd_arr);

            $data['proj'] = $request;
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

    public function destroy($id)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            Log::info($id);
            DB::beginTransaction();

            App\Projects::where('id', $id)->delete();
            // DB::rollback();
            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        Log::info(json_encode(DB::getQueryLog()));
        $data['msg'] = $msg;
        $data['status'] = $status;
        return Response::json($data);
    }
}
