<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Program;
use Request;
use Response;

class ProgramController extends Controller
{
    public function index()
    {
        try {
            $program = Program::all('id', 'name');
            return Response::json($program);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }
}
