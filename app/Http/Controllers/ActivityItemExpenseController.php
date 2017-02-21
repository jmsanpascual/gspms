<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\ActivityItemExpense;
use App\ProjectExpense;

use Exception;
use DB;
class ActivityItemExpenseController extends Controller
{
    public function index(Request $request)
    {
        $activity_id = $request->activity_id;
        $expense = ActivityItemExpense::where('activity_id', $activity_id)->get();
        return $expense;
    }

    public function form($action)
    {
        $title = trans('activity-item-expense.title.'.$action);
        return view('modals.activity-item-expense', compact('title'));
    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg;
        try {
            DB::beginTransaction();
            // be sure it wont exceed the project expense
            $proj_expense = ProjectExpense::find($request->project_expense_id);
            $total = ($request->price * $request->quantity);
            if($proj_expense->amount < $total)
                throw new Exception('Error. Exceeded the limit of project expense.');

            $expense = new ActivityItemExpense();
            $expense->activity_id = $request->activity_id;
            $expense->project_expense_id = $request->project_expense_id;
            $expense->item_name = $request->item_name;
            $expense->description = $request->description;
            $expense->price = $request->price;
            $expense->quantity = $request->quantity;
            $expense->quantity_label = $request->quantity_label;
            $expense->remarks = $request->remarks;
            $expense->save();

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
            DB::rollback();
        }

        return compact('expense', 'status', 'msg');
    }

    public function update(Request $request)
    {

        $status = FALSE;
        $msg;
        try {
            DB::beginTransaction();

            // be sure it wont exceed the project expense
            $proj_expense = ProjectExpense::find($request->project_expense_id);
            $total = ($request->price * $request->quantity);
            if($proj_expense->amount < $total)
                throw new Exception('Error. Exceeded the limit of project expense.');

            $expense = ActivityItemExpense::find($request->id);
            // $expense->activity_id = $request->activity_id;
            $expense->project_expense_id = $request->project_expense_id;
            $expense->item_name = $request->item_name;
            $expense->description = $request->description;
            $expense->price = $request->price;
            $expense->quantity = $request->quantity;
            $expense->quantity_label = $request->quantity_label;
            $expense->remarks = $request->remarks;
            $expense->save();

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
            DB::rollback();
        }

        return compact('expense', 'status', 'msg');
    }
}
