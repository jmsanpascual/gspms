<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
use DB;
use App\Project;
use App\ProjectItemCategory;
use App\Item;
use File;

class ItemController extends Controller
{
  public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

    public function index(Request $request)
    {
        $status = FALSE;
        $msg = '';
        $data = array();

        try {
            $proj_id = $request->get('proj_id');
            if(EMPTY($proj_id))
                return;

            $item = (new App\ProjectItemCategory)->getTable();
            $category = (new App\Category)->getTable();
            Log::info('line 24 - - - -');
            $token = csrf_token();
            $data['items'] = App\ProjectItemCategory::JoinCategory()
                ->leftJoin('project_attachments', 'project_attachments.proj_item_category_id', '=', $item.'.id')
                ->select('item_name', $category . '.name AS category', $item . '.id',
                $item.'.description','category_id', 'quantity', 'price', 'quantity_label',
                DB::Raw('"'. $token . '" AS token'), 'project_attachments.id AS project_attachment_id')->where('proj_id', $proj_id)
                ->get();
            $status = TRUE;
            logger(json_encode($data));
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return array($data);
    }

    public function itemCategoryList($proj_id) {

        $data['items'] = App\ProjectItemCategory::where('proj_id', $proj_id)
            ->get(['id', 'item_name']);

        return $data;
    }

    public function show()
    {
        return view('modals/items');
    }

    public function store(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {

            $br = $request->all();
            Log::info('br');
            Log::info($br);
            unset($br['token']);
            // unset($br['upload_files']);
            unset($br['project_attachment_id']);
            $data = DB::transaction(function() use($br, $request){
                $data = array();
                $id = App\ProjectItemCategory::insertGetId($br);
                // get status name
                $cat_name = App\Category::where('id', $br['category_id'])
                  ->value('name');
                $data['items'] = $br;
                $data['items']['id'] = $id;
                $data['items']['category'] = $cat_name;

                // Adds item name to items table if it does not exist
                if (! Item::where('name', 'like', $data['items']['item_name'])->exists()) {
                    Item::insert(['name' => $data['items']['item_name']]);
                }

                // $data['items']['files'] = $this->_addAttachment($request);

                $data['total_expense'] = $this->_getTotalExpense($br['proj_id']);

                return $data;
            });

            // Make the status to on-going from initiating
            $ongoingId = 1;
            $approvedId = 5;
            $project = Project::findOrFail($br['proj_id']);

            if ($project->proj_status_id == $approvedId) {
                $project->proj_status_id = $ongoingId;
                $project->save();
            }
            $status = TRUE;
       } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
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

    private function _addAttachment($request) {
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

            $data->files = ProjectAttachmentFile::where('project_attachment_id', $proj_attachment->id)
                ->get(['id','project_attachment_id', 'name', 'file'])->toArray();

            return $data;
        }
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
            // unset($br['upload_files']);
            unset($upd_arr['project_attachment_id']);

            App\ProjectItemCategory::where('id', $id)->update($upd_arr);

            $data['items'] = $request;
            $data['total_expense'] = $this->_getTotalExpense($upd_arr['proj_id']);
            // logger();
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

    public function getPriceRecommendation(Request $request)
    {
        $item = $request->all();
        $forApproval = 2;
        $recommendedPrice = 'Unavailable';
        $categoryId = $item['category_id'];
        $yearAgo = date('Y-m-d', strtotime('-1 years'));

        // logger('////////////////////////'.json_encode($item));

        if (! isset($item['item_name'])) {
            return compact('recommendedPrice');
        }

        $projectIds = Project::where('proj_status_id', '!=', $forApproval)
                    ->where('start_date', '>', $yearAgo)->pluck('id');
        // logger($projectIds);

        $recommendedPrice = ProjectItemCategory::select(DB::raw('avg(price) as averagePrice'))
                      ->where(function ($query) use ($categoryId, $projectIds) {
                            $query->where('category_id', '=', $categoryId)
                            ->whereIn('proj_id', $projectIds);
                        })
                      ->where('item_name', $item['item_name'])
                      ->value('averagePrice');

        $recommendedPrice = round($recommendedPrice, 2);
        return compact('recommendedPrice');
    }

    public function getAllItems()
    {
        $items = Item::all();
        return compact('items');
    }

    public function _getTotalExpense($id)
    {
        return App\ProjectItemCategory::where('proj_id', $id)
        ->sum(DB::raw('quantity * price'));
    }

    public function getTotalExpense($id)
    {
        $msg = '';
        $status = FALSE;
        try {
            $data['total_expense'] = $this->_getTotalExpense($id);

            $status = TRUE;
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return $data;
    }
}
