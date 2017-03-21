<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Expertise;
use Response;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expertise::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modals/volunteer-expertise');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expertiseInfo = $request->get('expertise');

        if (Expertise::where('name', '=', $expertiseInfo['name'])->exists()) {
            return ['error' => 'Expertise already exist.'];
        } else {
            $expertise = Expertise::create($expertiseInfo);
            return ['id' => $expertise->id];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $expertise = $request->get('expertise');
            Expertise::where('id', $expertise['id'])->update($expertise);
        } catch (\Exception $e) {
            Response::json(['error' => $e->getMessage()]);
        }

        return Response::json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Expertise::where('id', $id)->delete();
            return Response::json(true);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }
}
