<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App;
use Log;
use DB;
class UserController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        return view('users');
    }

    public function create(Request $input)
    {
        
    }

    public function retrieve()
    {
        $status = FALSE;
        DB::connection()->enableQueryLog();
        try
        {
            $data['users'] = App\Account::all();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }

        Log::info(json_encode(DB::getQueryLog()));
        $data['status'] = $status;
        return $data;
    }

    public function update(Request $input)
    {

    }

    public function delete()
    {

    }

}
