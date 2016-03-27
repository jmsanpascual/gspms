<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FundAllocation;
use Response;
use Log;

class FundAllocationController extends Controller
{
    public function index()
    {
        $allocatedFunds = FundAllocation::
        with(array('project' =>
            function ($query) {
                $query->where('proj_status_id', '1');
            }
        ))->get();

        return Response::json($allocatedFunds);
    }

    public function create()
    {
        return view('modals/funds-allocation');
    }

    public function store(Request $request)
    {
        try {
            $allocatedFund = $request->all();

            // Insert the personal info and get the id
            $allocatedFundId = FundAllocation::insertGetId($allocatedFund);
            $allocatedFund['id'] = $allocatedFundId;

            return Response::json($allocatedFund);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $allocatedFund = $request->all();

            FundAllocation::where('id', $allocatedFund['id'])->update($allocatedFund);
            return Response::json(['result' => true]);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            FundAllocation::where('id', $id)->delete();
            return Response::json(true);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }
}
