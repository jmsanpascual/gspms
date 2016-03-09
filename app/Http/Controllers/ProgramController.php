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
    	$status = FALSE;
    	$msg = '';
        try {
            $data['program'] = Program::all('id', 'name');
            $status = TRUE;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return array($data);
    }
}
