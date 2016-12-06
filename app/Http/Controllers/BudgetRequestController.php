<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use Response;
use Log;
use App\Fund;
use Exception;
use App\UserRoles;

use App\Traits\Notify;

class BudgetRequestController extends Controller
{
	use Notify;

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
    		// Log::info('proj_id');
    		// Log::info($proj_id);
            if(EMPTY($proj_id))
                return;

            $br = (new App\ProjectBudgetRequest)->getTable();
            $br_status = (new App\BudgetRequestStatus)->getTable();
            $token = csrf_token();
    		$data['budget_requests'] = App\ProjectBudgetRequest::JoinBudgetStatus()
    			->select("$br.id", "proj_id", "amount", "reason", "status_id",
                DB::Raw('"'. $token . '" AS token'), $br_status . ".name AS status", "$br.remarks")
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

    public function show()
    {
        return view('modals/budget-request');
    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {
            $br = $request->all();
            // Log::info('br');
            // Log::info($br);
            unset($br['token']);
			DB::beginTransaction();
			$br['status_id'] = 1;
            $id = App\ProjectBudgetRequest::insertGetId($br);

			$proj = App\Project::find($br['proj_id']);
			$this->_notifyFinanceForApproval($proj);
            // get status name
            $stat_name = App\BudgetRequestStatus::where('id', $br['status_id'])
            	->value('name');
            $data['brequest'] = $br;
            $data['brequest']['id'] = $id;
            $data['brequest']['status'] = $stat_name;
            $status = TRUE;
			DB::commit();
       } catch (\Exception $e) {
		   DB::rollback();
				//  Log::info(json_encode(DB::getQueryLog()));
            $msg = $e->getMessage();

        }
					// Log::info(json_encode(DB::getQueryLog()));
        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

	private function _notifyFinanceForApproval($proj, $edit = FALSE)
    {
        try {
            if($edit) {
                // notify finance of edited project
                $finance = config('constants.role_finance');
                $finance_emp = UserRoles::where('role_id', $finance)->lists('user_id');

                $data = [
                    'title' => 'Budget Request Edit',
                    'text' => trans('notifications.budget_request_edit_for_approval', ['name' => $proj['name']]),
                    'proj_id' => $proj['id'],
                    'user_ids' => $finance_emp
                ];

                return $this->saveNotif($data);
            }

            $finance = config('constants.role_finance');
            $finance_emp = UserRoles::where('role_id', $finance)->lists('user_id');
            // logger($finance_emp);
            $data = [
                'title' => 'Budget Request',
                'text' => trans('notifications.budget_request', ['name' => $proj['name']]),
                'proj_id' => $proj['id'],
                'user_ids' => $finance_emp
            ];

            $this->saveNotif($data);
        } catch(Exception $e) {
            throw $e;
        }

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
			DB::beginTransaction();
            $upd_arr['status_id'] = 1; // for approval

            App\ProjectBudgetRequest::where('id', $id)->update($upd_arr);
            $stat_name = App\BudgetRequestStatus::where('id', $upd_arr['status_id'])
                ->value('name');

			$proj = App\Project::find($upd_arr['proj_id']);
			$this->_notifyFinanceForApproval($proj, true);

            $data['brequest'] = $request;
            $data['brequest']['status_id'] = $upd_arr['status_id'];
            $data['brequest']['status'] = $stat_name;
            $status = TRUE;
			DB::commit();
        }
        catch(\Exception $e)
        {
			DB::rollback();
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
            $stat = App\ProjectBudgetRequest::where('id', $req->get('br_id'));
			$br = $stat->first();
			$this->_deductFund($req, $br);

	        $stat->update([
                'status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ]);

            $data['stat'] = App\BudgetRequestStatus::where('id', $req->get('id'))->first(['id','name']);

			// if approved get total budget
			if($req->get('id') == 2)
			$data['total_budget'] = $this->_getTotalBudget($br->proj_id);
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

	private function _deductFund($req, $br)
	{
		$status = config('constants.budget_request_approved');
		// if not approved
		if($req->get('id') != $status) return;
		// if approve deduct fund
		try {
			if(EMPTY($br->amount)) throw new Exception('Amount is missing on approve.');

            // get year today
            $year = date('Y');
            $fund = Fund::where('year', $year)->first();

            if(EMPTY($fund)) throw new Exception('No Funds yet on this year');
            if($fund->remaining_funds < $br->amount) throw new Exception('Insufficient funds on requested budget.');

            $fund->remaining_funds -= $br->amount;
            $fund->save();
		} catch(Exception $e) {
			throw $e;
		}
	}

    public function destroy($id)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            Log::info($id);
            DB::beginTransaction();

            App\ProjectBudgetRequest::where('id', $id)->delete();
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

	private function _getTotalBudget($id)
	{
		return App\ProjectBudgetRequest::where('proj_id', $id)
			// 2 = approve
			->where('status_id', 2)->sum('amount');
	}

	public function getTotalBudget($id)
	{
		$msg = '';
		$status = FALSE;
		try {
			$data['total_budget'] = $this->_getTotalBudget($id);
			$status = TRUE;
		} catch(Exception $e) {
			logger($e);
			$msg = $e->getMessage();
		}

		$data['status'] = $status;
		$data['msg'] = $msg;

		return $data;
	}
}
