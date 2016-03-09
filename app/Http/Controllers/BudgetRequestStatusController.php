<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class BudgetRequestStatusController extends Controller
{
    //
    public function index()
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		$data['br_status'] = App\BudgetRequestStatus::select('id','name')->get();
    		$status = TRUE;
    	}
    	catch(Exception $e)
    	{
    		$msg = $e->getMessage();
    	}
    	$data['msg'] = $msg;
    	$data['status'] = $status;
    	return array($data);
    }
}
