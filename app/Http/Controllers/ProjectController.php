<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use App;
use Response;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $project = App\Project::all();
            return Response::json($project);
        } catch (Exception $e) {
            return Response::json(array('error' => $e->getMessage()));
        }
    }

    public function create()
    {
        return view('create-project');
    }

    public function store()
    {
        try {
            $project = Request::all();
            App\Project::insert($project);
            return Response::json(arrya(true));
        } catch (Exception $e) {
            return Response::json(array('error' => $e->getMessage()));
        }
    }
}
