<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
use DB;

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

        try
        {
        	Log::info($request->all());
    		$proj_id = $request->get('proj_id');
    		Log::info('proj_id');
    		Log::info($proj_id);
            if(EMPTY($proj_id))
                return;

            $item = (new App\ProjectItemCategory)->getTable();
            $category = (new App\Category)->getTable();
            Log::info('line 24 - - - -');
            $token = csrf_token();
            $data['items'] = App\ProjectItemCategory::JoinCategory()
                        ->select('item_name', $category . '.name AS category', $item . '.id', 
                        $item.'.description','category_id', 'quantity', 'price',
                        DB::Raw('"'. $token . '" AS token'))->where('proj_id', $proj_id)
                        ->get();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;
       
        return array($data);
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
            $id = App\ProjectItemCategory::insertGetId($br);
            // get status name
            $cat_name = App\Category::where('id', $br['category_id'])
            	->value('name');
            $data['items'] = $br;
            $data['items']['id'] = $id;
            $data['items']['category'] = $cat_name;
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
