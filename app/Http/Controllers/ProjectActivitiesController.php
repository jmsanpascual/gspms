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
use App\Project;
use App\ProjectItemCategory;
use App\ProjectExpense;
use Exception;

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
    		$data['proj_activities'] = App\ProjectActivities::with('tasks')
                                    ->joinActivityStatus()
                                    ->select("$activity.id","$activity.name", "$activity.start_date",
                                    "$activity.end_date", "$activity.remarks", "$act_status.name AS status",
                                    "$activity.status_id", "$activity.description", "quantity", "item_id", "proj_activities.activity_id",
                                    "$activity.phase_id", DB::Raw('"'. $token . '" AS token'))
    								->where('proj_id', $proj_id)->get();
            // Log::info(' lINE 33 - - - - -');
            // Log::info(json_encode(DB::getQueryLog()));
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
            // Log::info($req->all());
            $proj_id = $req->get('proj_id');
            $activity = $req->all();
            // logger($activity);
            // if(!EMPTY($activity['item'])) {
            //     if(EMPTY($activity['quantity'])) {
            //         throw new Exception('Error. Quantity is required if there is an item specified');
            //     }
            //
            //     // check quantity should not exceed to max
            //     if($activity['quantity'] > $activity['item']['quantity']) {
            //         throw new Exception('Error. Quantity exceeded the maximum items available, Please try again.');
            //     }
            //
            //     $activity['item_id'] = $activity['item']['id'];
            //     unset($activity['item']);
            // } else if(!EMPTY($activity['quantity'])) {
            //     if(EMPTY($activity['item'])) {
            //         throw new Exception('Error. Please specify items if there is a quantity.');
            //     }
            // }
            unset($activity['proj_id']);
            unset($activity['token']);
            // Log::info($proj_id);
            // Log::info($activity);
            DB::beginTransaction();
            $activity['status_id'] = 1;
            $activity['start_date'] = date('Y-m-d H:i:s', strtotime($activity['start_date']));
            // Log::info(' start date '. $activity['start_date']);
            $activity['end_date'] = date('Y-m-d H:i:s', strtotime($activity['end_date']));

            // Get and remove tasks before inserting the activity
            $tasks = $activity['tasks'];
            unset($activity['tasks']);

            $id = App\Activities::insertGetId($activity);
            App\ProjectActivities::insert(['proj_id' => $proj_id, 'activity_id' => $id]);
            $stat = App\ActivityStatus::where('id', $activity['status_id'])->value('name');

            // Add the activity id to tasks
            foreach ($tasks as $key => $value) {
                $tasks[$key]['activity_id'] = $id;
                $tasks[$key]['done'] = 0;
            }

            App\ActivityTask::insert($tasks); // Insert tasks
            $data['projAct'] = $req->all();
            $data['projAct']['id'] = $id;
            $data['projAct']['status'] = $stat;

            if(!EMPTY($activity['item_id']))
            $data['projAct']['item_id'] = $activity['item_id'];

            // Make the status to on-going from initiating
            $ongoingId = config('constants.proj_status_ongoing');
            $approvedId = config('constants.proj_status_approved');
            $project = Project::findOrFail($proj_id);

            if ($project->proj_status_id == $approvedId) {
                $project->proj_status_id = $ongoingId;
                $project->save();
            } else if($project->proj_status_id == config('constants.proj_status_incomplete')) {
                // check if already have a expense
                $count = ProjectExpense::where('proj_id', $project->id)->count();
                if($count) {
                    $project->proj_status_id = config('constants.proj_status_for_approval_finance');
                    $project->save();
                }
            }

            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            DB::rollback();
            $msg = $e->getMessage();
            // logger($e);
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

            $taskIds = [];
            $proj_id = $req->get('proj_id');
            $act_id = $req->get('id');
            $activity = $req->all();
            // if(!EMPTY($activity['item'])) {
            //     if(EMPTY($activity['quantity'])) {
            //         throw new Exception('Error. Quantity is required if there is an item specified');
            //     }
            //
            //     // check quantity should not exceed to max
            //     if($activity['quantity'] > $activity['item']['quantity']) {
            //         throw new Exception('Error. Quantity exceeded the maximum items available, Please try again.');
            //     }
            //
            //     $activity['item_id'] = $activity['item']['id'];
            //     unset($activity['item']);
            // } else if(!EMPTY($activity['quantity'])) {
            //     if(EMPTY($activity['item'])) {
            //         throw new Exception('Error. Please specify items if there is a quantity.');
            //     }
            //     unset($activity['item']);
            // }
            unset($activity['proj_id']);
            unset($activity['id']);
            unset($activity['status']);
            unset($activity['token']);
            DB::beginTransaction();
            // This line of code will revert back the status to for approval
            // $activity['status_id'] = 1;

            // Get and remove tasks before inserting the activity
            $tasks = $activity['tasks'];
            unset($activity['activity_id']);
            unset($activity['tasks']);

            Log::info($activity);
            $id = App\Activities::where('id', $act_id)->update($activity);
            // $stat = App\ActivityStatus::where('id', $activity['status_id'])->value('name');

            if (! empty($tasks)) {
                // Update the tasks
                foreach ($tasks as $key => $value) {
                    // Update the activity tasks
                    if (!isset($tasks[$key]['id'])) {
                        $tasks[$key]['activity_id'] = $act_id;
                        $taskId = App\ActivityTask::insertGetId($tasks[$key]);
                        $taskIds[] = ['id' => $taskId, 'name' => $tasks[$key]['name']];
                    } else {
                        App\ActivityTask::where('id', $tasks[$key]['id'])->update($tasks[$key]);
                    }
                }
            }

            $data['projAct'] = $req->all();
            // $data['projAct']['status_id'] = $activity['status_id'];
            // $data['projAct']['status'] = $stat;

            if(!EMPTY($activity['item_id']))
            $data['projAct']['item_id'] = $activity['item_id'];

            // Make the status to on-going from initiating
            $ongoingId = config('constants.proj_status_ongoing');
            $approvedId = config('constants.proj_status_approved');
            $project = Project::findOrFail($proj_id);

            if ($project->proj_status_id == $approvedId) {
                $project->proj_status_id = $ongoingId;
                $project->save();
            }

            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            DB::rollback();
            $msg = $e->getMessage();
            // logger($e);
        }
        $data['status'] = $status;
        $data['msg'] = $msg;
        $data['taskIds'] = $taskIds;

        return Response::json($data);
    }

    public function updateStatus(Request $req)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            // missing check if for approval
            $stat = App\Activities::where('id', $req->get('act_id'))
            ->update([
                'status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ]);

            $data['stat'] = App\ActivityStatus::where('id', $req->get('id'))->first(['id','name']);
            Log::info('stat' . json_encode($data['stat']));

            $proj_id = App\ProjectActivities::where('activity_id', $req->get('act_id'))->value('proj_id');
            // Make the status to on-going from initiating
            $ongoingId = config('constants.proj_status_ongoing');
            $approvedId = config('constants.proj_status_approved');
            $project = Project::findOrFail($proj_id);

            if ($project->proj_status_id == $approvedId) {
                $project->proj_status_id = $ongoingId;
                $project->save();
            }
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

    public function updateTask(Request $request)
    {
        $task = $request->all();

        App\ActivityTask::where('id', $task['id'])->update($task);

        $data['status'] = TRUE;
        return $data;
    }

    public function deleteTask($id) {
        App\ActivityTask::where('id', $id)->delete();
        return;
    }
}
