<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class ProjectController extends Controller
{
    //
    public function index()
    {
    	return View('projects');
    }

    public function fetch()
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		$data['proj'] = App\Projects::all();
    		$status = TRUE;
    	}
    	catch(Exception $e)
    	{
    		$msg = $e->getMessage();
    	}
    	$data['status'] = $status;
    	$data['msg'] = $msg;

    	return json_encode($data);
    }
}
