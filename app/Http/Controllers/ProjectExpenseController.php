<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projects;
use App\ProjectExpense;
use App\ProjectBudgetRequest;
use Exception;
use DB;
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
}
