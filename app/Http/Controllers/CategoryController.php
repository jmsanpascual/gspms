<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;

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

    public function store(Request $req)
    {
        $ins_arr = $req->all();
        $id = App\Category::insertGetId($ins_arr);
        $data = array(
            'status' => TRUE,
            'item_category' => array(
                'id' => $id,
                'name' => $ins_arr['name']
            )
        );
        
        return Response::json($data);
    }
}
