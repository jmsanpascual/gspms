<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Fund;
use Response;
use Log;
use DB;

class FundController extends Controller
{
    public function index()
    {
        try {
            $funds = Fund::all();
            return Response::json($funds);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function store(Request $request)
    {
        try {
            $fund = $request->all();
            $fundId = Fund::insertGetId($fund);
            $fund['id'] = $fundId; // Insert the id to fund object

            return Response::json($fund);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }
}
