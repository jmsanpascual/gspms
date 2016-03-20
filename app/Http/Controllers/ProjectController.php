<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
use DB;
use Session;

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
            $token = csrf_token();
            $data['proj'] = App\Projects::JoinStatus()
                        ->select($proj . '.name', $stat . '.name AS status', $proj . '.id', 
                        'start_date','end_date', 'objective', 'total_budget', 'champion_id', 
                        'program_id', 'proj_status_id', 'resource_person_id', 'partner_organization',
                        'partner_community', DB::Raw('"'. $token . '" AS token'))
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
            $token = csrf_token();
            $data['proj'] = App\Projects::select('id', 'name', 'start_date','end_date', 'objective', 
                'total_budget', 'champion_id', 'program_id', 'proj_status_id', 'resource_person_id',
                'partner_organization', 'partner_community', DB::Raw('"'. $token . '" AS token'))
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
            unset($project['token']);
            // unset($project['status_id']);
            $project['proj_status_id'] = 2; // FOR APPROVAL
            if(EMPTY($project['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $project['champion_id'] = Session::get('id');

            $project['start_date'] = date('Y-m-d H:i:s', strtotime($project['start_date']));
            Log::info(' start date '. $project['start_date']);
            $project['end_date'] = date('Y-m-d H:i:s', strtotime($project['end_date']));
            $project['id'] = App\Project::insertGetId($project);
            // get status name
            $stat_name = App\ActivityStatus::where('id', $project['proj_status_id'])->value('name');
            $data['proj'] = $project;
            $data['proj']['proj_status_id'] = $project['proj_status_id'];
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
            unset($upd_arr['token']);
            unset($upd_arr['status_id']);
            $upd_arr['proj_status_id'] = 2;
            if(EMPTY($upd_arr['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $upd_arr['champion_id'] = Session::get('id');
            $upd_arr['start_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['start_date']));
            Log::info(' start date '. $upd_arr['start_date']);
            $upd_arr['end_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['end_date']));
            App\Projects::where('id', $id)->update($upd_arr);
            $stat = App\ProjectStatus::where('id', $upd_arr['proj_status_id'])->value('name');
            $data['proj'] = $request;
            $data['proj']['proj_status_id'] = $upd_arr['proj_status_id'];
            $data['proj']['status'] = $stat;
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

    public function updateStatus(Request $req)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            // missing check if for approval
            $stat = App\Project::where('id', $req->get('proj_id'))
            ->update([
                'proj_status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ]);

            $data['stat'] = App\ProjectStatus::where('id', $req->get('id'))->first(['id','name']);
            Log::info('stat' . json_encode($data['stat']));
            $status = TRUE;
        }
        catch(Exception $e)
        {
            Log::info(json_encode(DB::getQueryLog()));
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

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
