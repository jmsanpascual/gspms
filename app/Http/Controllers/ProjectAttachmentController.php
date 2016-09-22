<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\ProjectAttachment;

use DB;
class ProjectAttachmentController extends Controller
{
    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

    public function index(Request $req) {
        $status = FALSE;
        $msg = '';
        try {
            $proj_id = $req->get('proj_id');

            if(EMPTY($proj_id))
                return;

            $attachment = ProjectAttachment::where('project_id', $proj_id)->select('*',
            DB::Raw('"'. $token . '" AS token'))->get();
            logger(' lINE 25 - - - - -');
            logger(json_encode(DB::getQueryLog()));

            $status = TRUE;
        }
        catch(Exception $e) {
            $msg = $e->getMessage();
        }

        $data = array(
            'msg' => $msg,
            'status' => $status,
            'attachment' => $attachment,
        );

        return array($data);
    }

    public function show()
    {
        return view('modals/project-attachment');
    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {
            // $br = $request->all();
            // unset($br['token']);
            // $br['created_by'] = auth()->id();
            // $id = ProjectAttachment::insertGetId($br);
            //
            // $data['attachment'] = $br;
            // $data['attachment']['id'] = $id;
            // $data['attachment']['name'] = $creator;

            $status = TRUE;
       } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

    public function update(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $request = $request->all();
            Log::info('update');
            Log::info($request);
            $id = $request['id'];
            $upd_arr = $request;
            unset($upd_arr['id']);
            unset($upd_arr['category']);
            unset($upd_arr['token']);
            App\ProjectItemCategory::where('id', $id)->update($upd_arr);

            $data['items'] = $request;
            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function destroy($id)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            Log::info($id);
            DB::beginTransaction();

            App\ProjectItemCategory::where('id', $id)->delete();
            // DB::rollback();
            DB::commit();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        Log::info(json_encode(DB::getQueryLog()));
        $data['msg'] = $msg;
        $data['status'] = $status;
        return Response::json($data);
    }
}
