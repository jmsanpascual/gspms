<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Milestone;
use Response;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modals/milestone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $milestoneInfo = $request->get('milestone');
        $milestoneId = 0;

        if (isset($milestoneInfo['id'])) {
            $milestoneId = $milestoneInfo['id'];
        }

        $milestone = Milestone::updateOrCreate(['id' => $milestoneId], $milestoneInfo);

        return ['id' => $milestone->id];
    }

    public function show($id)
    {
        try {
            $milestone = Milestone::where('project_id', $id)->first();

            return Response::json($milestone);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    function graph()
    {
        return view('modals/milestone-graph');
    }
}
