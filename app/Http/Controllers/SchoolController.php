<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\School;
use Response;

class SchoolController extends Controller
{
    function index()
    {
        try {
            $schools = School::all('id', 'name');
            return Response::json($schools);
        } catch (Exception $e) {
            return Response::json(array('error' => $e->getMessage()));
        }
    }
}
