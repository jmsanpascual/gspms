<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Project;
use App\ProjectAttachment;
use App\ProjectAttachmentFile;

use DB;
use File;
use Exception;

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

            $token = csrf_token();
            $attachment = ProjectAttachment::where('project_id', $proj_id)->select('*',
            DB::Raw('"'. $token . '" AS token'))
            ->get();

            foreach($attachment AS $key => &$val) {
                $val['files'] = ProjectAttachmentFile::where('project_attachment_id', $val->id)
                  ->get(['id', 'project_attachment_id','file', 'name'])->toArray();
            }

            // logger(' lINE 25 - - - - -');
            // logger(json_encode(DB::getQueryLog()));

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
            // logger(' request ');
            // logger($request);
            $params = $request->all();

            $data['attachment'] = DB::transaction(function() use ($params, $request){
                $proj_attachment = new ProjectAttachment();
                $proj_attachment->project_id = $params['project_id'];
                $proj_attachment->subject = $params['subject'];
                $proj_attachment->description = $params['description'];
                $proj_attachment->created_by = auth()->id();
                $proj_attachment->save();

                //set name of the creator
                // $proj_attachment->name = auth()->user()->name;

                // save the files
                if($request->has('upload_files')) {
                    // check or create first the directory
                    $path = $this->_getAttachmentPath();
                    $files = [];
                    foreach($request->file('upload_files') AS $key => $val) {
                        $fileName = sha1($val->getClientOriginalName() . time());
                        $fileName = $fileName . '.' . $val->getClientOriginalExtension();
                        $files[] = [
                            'project_attachment_id' => $proj_attachment->id,
                            'file' => $fileName,
                            'name' => $val->getClientOriginalName()
                        ];

                        $val->move($path, $fileName);
                    }
                    ProjectAttachmentFile::insert($files);

                    $proj_attachment->files = ProjectAttachmentFile::where('project_attachment_id', $proj_attachment->id)
                        ->get(['id','project_attachment_id', 'name', 'file'])->toArray();
                }
                // logger($proj_attachment);

                // Make the status to on-going from initiating
                $ongoingId = 1;
                $approvedId = 5;
                $project = Project::findOrFail($params['project_id']);

                if ($project->proj_status_id == $approvedId) {
                    $project->proj_status_id = $ongoingId;
                    $project->save();
                }

                return $proj_attachment;
            });

            // $data['attachment'] = $br;
            // $data['attachment']['id'] = $id;
            // $data['attachment']['name'] = $creator;
            $msg = trans('notifications.data_saved');
            $status = TRUE;
       } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return response()->json($data);
    }

    private function _getAttachmentPath() {
        $path = $this->_getPath();
        if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, TRUE);
        }
        return $path;
    }

    private function _getPath() {
        return public_path() . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR;
    }

    public function update(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {
            $params = $request->all();
            // logger($params);
            $data['attachment'] = DB::transaction(function() use ($params, $request){
                $proj_attachment = ProjectAttachment::find($params['id']);
                $proj_attachment->project_id = $params['project_id'];
                $proj_attachment->subject = $params['subject'];
                $proj_attachment->description = $params['description'];
                $proj_attachment->created_by = auth()->id();
                $proj_attachment->save();

                //set name of the creator
                $proj_attachment->name = auth()->user()->name;

                // save the files
                if($request->has('upload_files')) {
                    // check or create first the directory
                    $path = $this->_getAttachmentPath();
                    $files = [];
                    foreach($request->file('upload_files') AS $key => $val) {
                        $fileName = sha1($val->getClientOriginalName() . time());
                        $fileName = $fileName . '.' . $val->getClientOriginalExtension();
                        $files[] = [
                            'project_attachment_id' => $proj_attachment->id,
                            'file' => $fileName,
                            'name' => $val->getClientOriginalName()
                        ];

                        $val->move($path, $fileName);
                    }
                    ProjectAttachmentFile::insert($files);

                    $proj_attachment->files = ProjectAttachmentFile::where('project_attachment_id', $proj_attachment->id)
                        ->get(['id','project_attachment_id', 'name', 'file'])->toArray();
                }

                return $proj_attachment;
            });

            // $data['attachment'] = $br;
            // $data['attachment']['id'] = $id;
            // $data['attachment']['name'] = $creator;
            $msg = trans('notifications.data_saved');
            $status = TRUE;
       } catch (Exception $e) {
            $msg = $e->getMessage();
            logger($e);
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return response()->json($data);
    }

    public function destroyAttachment($id) {
        $status = FALSE;
        try{
            //remove first the file
            $attachment = ProjectAttachmentFile::where('id', $id)->first()->makeVisible('dirFile')->toArray();
            File::delete($attachment['dirFile']);
            // delete from database
            ProjectAttachmentFile::destroy($id);
            $msg = trans('notifications.data_deleted', ['str' => 'Attachmemnt']);
            $status = TRUE;
        } catch(Exception $e) {
            $msg = $e->getMessage();
        }
        $data = [
            'status' => $status,
            'msg' => $msg
        ];

        return $data;
    }

    public function destroy($id)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            DB::beginTransaction();
            $attachment = ProjectAttachmentFile::where('project_attachment_id', $id)
              ->get()->makeVisible('dirFile')->toArray();

            $ids = array_column($attachment, 'id');
            $files = array_column($attachment, 'dirFile');

            // destroy the files
            if(!EMPTY($files)) {
                File::delete($files);
            }

            ProjectAttachmentFile::whereIn('id', $ids)->delete();
            // destroy the parent
            ProjectAttachment::destroy($id);
            $status = TRUE;
            $msg = trans('notifications.data_deleted', ['str' => 'Attachment']);
            DB::commit();
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
            DB::rollback();
            logger($e);
        }
        $data['msg'] = $msg;
        $data['status'] = $status;
        return response()->json($data);
    }
}
