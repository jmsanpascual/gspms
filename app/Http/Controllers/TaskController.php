<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\Http\Requests;
use App\Task;
use Response;
use Hash;
use Lang;
use Log;
use DB;

use App\Traits\Notify;
class TaskController extends Controller
{
    use Notify;

    protected $roleId = 6;
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index()
    {
        $roleId = $this->roleId;

        try {
            $tasks = Task::with('activity.projects')->where('user_id', $this->user->id)->get();

            return Response::json($tasks);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function create()
    {
        return view('modals/task');
    }

    public function update(Request $request)
    {
        try {
            $task = $request->get('task');
            $taskId = $task['id'];
            unset($task['activity']);

            Task::where('id', $taskId)->update($task);

            // $this->notifyChampion();

            return Response::json(['result' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function notifyChampion()
    {
        $data = [
            'title' => 'Project Edited',
            'text' => trans('notifications.project_edited', ['name' => $proj['name']]),
            'proj_id' => $proj['id'],
            'user_ids' => [$proj['champion_id']]
        ];

        return $this->saveNotif($data);
    }

    public function statusReport($id)
    {
        $status = FALSE;
        $msg = '';

        try {
            $data['proj'] = App\Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
                ->leftJoin('resource_persons AS rp', 'rp.id', '=', 'projects.resource_person_id')
                ->leftJoin('personal_info AS rpi', 'rpi.id','=', 'rp.personal_info_id')
                ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
                ->leftJoin('user_info', 'user_info.user_id','=','users.id')
                ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
                ->where('projects.id', $id)->first([
                    'projects.*','programs.name AS program', 'total_budget',
                    'rpi.first_name', 'rpi.middle_name', 'rpi.last_name',
                    DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')
                ], 'remarks');

            $data['activities'] = App\ProjectActivities::where('proj_id', $id)
                ->leftJoin('activities', 'activities.id', '=', 'proj_activities.activity_id')
                ->get(['name', 'id']);

            foreach($data['activities'] AS $key => $val) {
                $data['activities'][$key]['tasks'] = App\Task::where('activity_id', $val['id'])
                    ->where('user_id', auth()->id())->get();
                if (count($data['activities'][$key]['tasks']) <= 0) {
                    unset($data['activities'][$key]);
                }
            }

            $data['expenses'] = App\ProjectExpense::where('proj_id', $id)->get();

            // Compute used by activities
            foreach($data['expenses'] AS &$val) {
                $val->items = App\ActivityItemExpense::where('project_expense_id', $val['id'])->get();
            }

            $data['total_expense'] = App\ProjectExpense::where('proj_id', $id)
                ->sum('amount');

            $data['total_budget_request'] = App\ProjectBudgetRequest::where('proj_id', $id)
                ->where('status_id', 2)->sum('amount');

            $data['total_budget'] = $data['proj']->total_budget + $data['total_budget_request'];
            $data['proj_id'] = $id;

            $start_date =  \Carbon\Carbon::createFromFormat('Y-m-d', $data['proj']->start_date);
            $end_date =  \Carbon\Carbon::createFromFormat('Y-m-d', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);

            $html = view('reports/volunteer-project-status', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();
            $pdf->writeHTML($html);

            $pdf->Output();
            exit();
        } catch(\Exception $e) {
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }
}
