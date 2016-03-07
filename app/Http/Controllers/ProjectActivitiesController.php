<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Log;
use Lang;
use Response;
use DB;
class ProjectActivitiesController extends Controller
{
    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

    public function index(Request $request)
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		// Log::info('line 24 - - -  PROJACT');
    		// Log::info($request->all());
    		$proj_id = $request->get('proj_id');
            if(EMPTY($proj_id))
                return;
            $activity = (new App\Activities)->getTable();
            $act_status = (new App\ActivityStatus)->getTable();
            $token = csrf_token();
    		$data['proj_activities'] = App\ProjectActivities::joinActivityStatus()
                                    ->select("$activity.id","$activity.name", "$activity.start_date", 
                                    "$activity.end_date", "$act_status.name AS status", "$activity.status_id",
                                    DB::Raw('"'. $token . '" AS token'))
    								->where('proj_id', $proj_id)->get();
            Log::info(' lINE 33 - - - - -');
            Log::info(json_encode(DB::getQueryLog()));
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

    // public function fetch($proj_id, $id)
    // {
    //     $status = FALSE;
    //     $msg = '';
    //     try
    //     {
    //         $proj_act = (new App\ProjectActivities)->getTable();
    //         $act = (new App\Activities)->getTable();
    //         $data['activities'] = App\ProjectActivities::joinActivities()
    //                         ->where("$proj_act.proj_id", $proj_id)->where("$act.id", $id)
    //                         ->first(["$act.id","$act.name", "$act.start_date", "$act.end_date", "$act.status_id"]);
    //         $status = TRUE;
    //     }
    //     catch(Exception $e)
    //     {
    //         $msg = $e->getMessage();
    //     }
    //     $data['status'] = $status;
    //     $data['msg'] = $msg;
    //     // Log::info(' LINE 68 - - - ');
    //     // Log::info($data);
    //     // Log::info(json_encode(DB::getQueryLog()));
    //     return Response::json($data);
    // }

    public function show()
    {
        return view('modals/project-activities');
    }

    public function store(Request $req)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            Log::info($req->all());
            $proj_id = $req->get('proj_id');
            $activity = $req->all();
            unset($activity['proj_id']);
            unset($activity['token']);
            Log::info($proj_id);
            Log::info($activity);
            DB::beginTransaction();
            $id = App\Activities::insertGetId($activity);
            App\ProjectActivities::insert(['proj_id' => $proj_id, 'activity_id' => $id]);
            $stat = App\ActivityStatus::where('id', $req->get('status_id'))->value('name');
            $data['projAct'] = $req->all();
            $data['projAct']['id'] = $id;
            $data['projAct']['status'] = $stat;
            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            DB::rollback();
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function update(Request $req)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $proj_id = $req->get('proj_id');
            $act_id = $req->get('id');
            $activity = $req->all();

            Log::info($activity);
            unset($activity['proj_id']);
            unset($activity['id']);
            unset($activity['status']);
            unset($activity['token']);
            Log::info($activity);
            DB::beginTransaction();
            $id = App\Activities::where('id', $act_id)->update($activity);
            $stat = App\ActivityStatus::where('id', $req->get('status_id'))->value('name');
            $data['projAct'] = $req->all();
            $data['projAct']['status'] = $stat;
            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            DB::rollback();
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
            
            App\ProjectActivities::where('activity_id', $id)->delete();
            App\Activities::where('id', $id)->delete();
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
