<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProjectStatus;
use Request;
use Response;

class ProjectStatusController extends Controller
{
    public function index()
    {
        try {
            $projectStatus = ProjectStatus::all('id', 'name');
            return Response::json($projectStatus);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }
}
