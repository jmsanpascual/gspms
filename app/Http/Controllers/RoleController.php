<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
class RoleController extends Controller
{
//
    public function index()
    {
    	$data['roles'] = App\Roles::select('id', 'name')->get();
    	return array($data);
    }
}
