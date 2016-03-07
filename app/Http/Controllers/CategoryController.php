<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class CategoryController extends Controller
{
    //
    public function index()
    {
    	$status = FALSE;
    	$msg = '';
    	try
    	{
    		$data['categories'] = App\Category::all(['id', 'name']);
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
