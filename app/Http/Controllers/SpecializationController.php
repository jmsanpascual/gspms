<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialization;
use App\Http\Requests;

use DB;
use Exception;
class SpecializationController extends Controller
{

    public function index(Request $request)
    {
        $specializations = Specialization::where('resource_person_id', $request->resource_id)->get();
        return $specializations;
    }

    public function form($action)
    {
        $title = trans('specialization.title.'.$action);
        return view('modals.specialization', compact('title'));

    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg;
        try {
            DB::beginTransaction();
            $specialization = new Specialization;
            $specialization->resource_person_id = $request->resource_id;
            $specialization->program_id = $request->program_id;
            $specialization->save();

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
            DB::rollback();
        }

        return compact('status', 'msg', 'specialization');
    }

    public function update(Request $request)
    {
        $status = FALSE;
        $msg;
        try {
            DB::beginTransaction();
            $specialization = Specialization::find($request->id);
            // $specialization->resource_person_id = $request->resource_person_id;
            $specialization->program_id = $request->program_id;
            $specialization->save();

            $status = TRUE;
            DB::commit();
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
            DB::rollback();
        }

        return compact('status', 'msg', 'specialization');
    }

    public function destroy($id)
    {
        Specialization::destroy($id);
    }
}
