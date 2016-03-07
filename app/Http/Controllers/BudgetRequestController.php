<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use Response;
use Log;
class BudgetRequestController extends Controller
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
    		Log::info($request->all());
    		$proj_id = $request->get('proj_id');
    		Log::info('proj_id');
    		Log::info($proj_id);
            if(EMPTY($proj_id))
                return;
            
            $br = (new App\ProjectBudgetRequest)->getTable();
            $br_status = (new App\BudgetRequestStatus)->getTable();
            $token = csrf_token();
    		$data['budget_requests'] = App\ProjectBudgetRequest::JoinBudgetStatus()
    			->select("$br.id", "proj_id", "amount", "reason", "status_id",
                DB::Raw('"'. $token . '" AS token'), $br_status . ".name AS status")
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
            Log::info('br');
            Log::info($br);
            unset($br['token']);
            $id = App\ProjectBudgetRequest::insertGetId($br);
            // get status name
            $stat_name = App\BudgetRequestStatus::where('id', $br['status_id'])
            	->value('name');
            $data['brequest'] = $br;
            $data['brequest']['id'] = $id;
            $data['brequest']['status'] = $stat_name;
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
            App\ProjectBudgetRequest::where('id', $id)->update($upd_arr);

            $data['brequest'] = $request;
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
}
