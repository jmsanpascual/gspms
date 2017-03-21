<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Fund;
use App\SchoolFund;
use App\ProjectFund;
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
            $newFund = $request->except(['school', 'received_date']);
            $school = $request->input('school');
            $receivedDate = $request->input('received_date');

            // Add neccessary columns to school funds
            $schoolFundInfo = [
                'school_id' => $school['id'],
                'amount' => $newFund['amount'],
                'year' => $newFund['year'],
                'received_date' => $receivedDate,
            ];

            // Check if there's an existing fund first
            $fund = Fund::where('year', $newFund['year'])->first();
            $schoolFund = SchoolFund::insert($schoolFundInfo);

            if (empty($fund)) {
                $newFund['remaining_funds'] = $newFund['amount'];
                $fundId = Fund::insertGetId($newFund);
                $newFund['id'] = $fundId; // Insert the id to fund object
            } else {
                // If fund does exist, add the new fund amount to the existing fund
                $fund->amount += $newFund['amount'];
                $fund->remaining_funds = $fund->amount;
                $fund->save();
                $newFund['id'] = $fund->id;
            }

            return Response::json($newFund);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    function getSchoolFunds()
    {
        $school_fund = SchoolFund::with('referer')->get()->toArray();
        $proj_fund = ProjectFund::with('referer')->get()->toArray();

        return [
            'schoolFunds' => $school_fund,
            'projectFunds' => $proj_fund
        ];
    }
}
