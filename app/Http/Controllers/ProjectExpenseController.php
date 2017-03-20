<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projects;
use App\ProjectExpense;
use App\ProjectActivities;
use App\ProjectBudgetRequest;
use Exception;
use DB;
use Carbon\Carbon;
use Response;

class ProjectExpenseController extends Controller
{
    public function index(Request $request)
    {
        $proj_id = $request->proj_id;

        $total_expense = $this->_getTotalExpense($request);
        $expense = ProjectExpense::where('proj_id', $proj_id)->get();
        return compact('expense', 'total_expense');
    }

    private function _getTotalExpense($request)
    {
        return ProjectExpense::where('proj_id', $request->proj_id)->sum('amount');
    }

    public function getTotalExpense(Request $request)
    {
        $total_expense = $this->_getTotalExpense($request);
        return compact('total_expense');
    }

    public function form($action)
    {
        $title = trans('project-expense.title.'.$action);
        return view('modals.project-expense', compact('title'));
    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg;
        try {
            DB::beginTransaction();
            $expense = new ProjectExpense;
            $expense->proj_id = $request->proj_id;
            $expense->category = $request->category;
            $expense->amount = $request->amount;
            $expense->remarks = $request->remarks;
            $expense->save();

            // get total expense after saving
            $total_expense = $this->_getTotalExpense($request);
            // check if it exceed the total budget
            $project = Projects::find($request->proj_id);
            $approved_budget = ProjectBudgetRequest::where('proj_id', $request->proj_id)
                ->where('status_id', 2)->sum('amount');
                // with sum of project total budget and approved budget
            $total_budget = $project->total_budget + $approved_budget;
            if(($total_budget - $total_expense) <= 0)
                throw new Exception('Insufficient project budget.');

            // Make the status to on-going from initiating
            $ongoingId = config('constants.proj_status_ongoing');
            $approvedId = config('constants.proj_status_approved');
            // logger('proj status ' . $project->proj_status_id);
            if ($project->proj_status_id == $approvedId) {
                $project->proj_status_id = $ongoingId;
                $project->save();
            } else if($project->proj_status_id == config('constants.proj_status_incomplete')) {
                // check if already have a activities
                $count = ProjectActivities::where('proj_id', $project->id)->count();
                // logger('test - - - -' . $count);
                if($count) {
                    $project->proj_status_id = config('constants.proj_status_for_approval_finance');
                    $project->save();
                }
            }

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
            DB::rollback();
        }

        return compact('status', 'msg', 'expense', 'total_expense');
    }

    public function update(Request $request)
    {
        $status = FALSE;
        $msg;
        try {

            DB::beginTransaction();
            $expense = ProjectExpense::find($request->id);
            // $expense->proj_id = $request->proj_id;
            $expense->category = $request->category;
            $expense->amount = $request->amount;
            $expense->remarks = $request->remarks;
            $expense->save();

            // get total expense after saving
            $total_expense = $this->_getTotalExpense($request);
            // check if it exceed the total budget
            $project = Projects::find($request->proj_id);
            $approved_budget = ProjectBudgetRequest::where('proj_id', $request->proj_id)
                ->where('status_id', 2)->sum('amount');
                // with sum of project total budget and approved budget
            $total_budget = $project->total_budget + $approved_budget;
            if(($total_budget - $total_expense) <= 0)
                throw new Exception('Insufficient project budget.');

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();

            DB::rollback();
        }

        return compact('status', 'msg', 'expense', 'total_expense');
    }


    public function report($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
            ->leftJoin('resource_persons AS rp', 'rp.id', '=', 'projects.resource_person_id')
            ->leftJoin('personal_info AS rpi', 'rpi.id','=', 'rp.personal_info_id')
            ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
            ->leftJoin('user_info', 'user_info.user_id','=','users.id')
            ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
            ->where('projects.id', $id)->first(['projects.*','programs.name AS program',
                'rpi.first_name', 'rpi.middle_name', 'rpi.last_name',
                DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')]);

            $data['total_expense'] = \App\ProjectItemCategory::where('proj_id', $id)
            ->sum(DB::raw('quantity * price'));

            $data['total_budget_request'] = \App\ProjectBudgetRequest::where('proj_id', $id)
    			// 2 = approve
    			->where('status_id', 2)->sum('amount');

            $data['total_budget'] = $data['proj']->total_budget + $data['total_budget_request'];

            $data['proj_id'] = $id;

            $start_date =  Carbon::createFromFormat('Y-m-d H:i:s',$data['proj']->start_date);
            $end_date =  Carbon::createFromFormat('Y-m-d H:i:s', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);
            $data['duration'] = $this->_convertToYearMonthDays($days);


            // $data['chart'] = $this->createChart($id);
            $html = view('reports/project', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();
            $pdf->writeHTML($html);
            $pdf->SetFooter('Generated date: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {

            $msg = $e->getMessage();
            // throw $e;
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function _convertToYearMonthDays($days)
    {
        $yearMonths = 12;
        $monthDays = 365.25/$yearMonths;
        $months = 0;
        $years = 0;

        // convert to month
        if($days > $monthDays) {
            $months = floor($days/$monthDays);
            // get the remainder
            $days = $days % $monthDays;
        }

        // convert to years
        if($months > $yearMonths) {
            $years = floor($months/$yearMonths);
            //get the remainder for months
            $months = $months%$yearMonths;
        }

        $format = $years . ' yr(s). '. $months . ' mo(s). ';

        return $format;
    }

}
