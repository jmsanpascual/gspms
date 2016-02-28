<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
class ActivityStatusController extends Controller
{
    //
    public function index()
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		$data['activity_status'] = App\ActivityStatus::all();
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
}
