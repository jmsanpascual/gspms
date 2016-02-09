<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App;
use Log;
use DB;
use Request;
use Hash;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('users');
    }

    public function create()
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $input = Request::all();

            Log::info('create');

            Log::info(json_encode($input));
            Log::info(json_encode($input['username']));

            // check if username or email already exist w/c is not yet deleted
            $result = App\User::leftJoin('user_info AS A', 'users.id', '=', 'A.user_id')
            ->leftJoin('personal_info AS B', 'A.personal_info_id', '=', 'B.id')
            ->where(function($query) use ($input) {
                $query->where('users.username', $input['username'])
                ->orWhere('B.email', $input['email']);
            })
            ->whereNull('users.deleted_at')
            ->whereNull('B.deleted_at')
            ->count();


            if($result > 0)
            {
                // throw new Exception('username or email already exist');
            }

            if($input['password'] != $input['repassword'])
            {
                // throw new Exception('password and confirm password are not equal');
            }
            DB::beginTransaction();
            $user_id = App\User::insertGetId([
                'username' => $input['username'],
                'password' => Hash::make($input['password'])
            ]);
            $personal_id = App\PersonalInfo::insertGetId([
                'first_name' => $input['fname'],
                'middle_name' => $input['mname'],
                'last_name' => $input['lname'],
                'contact_num' => $input['cnum'],
                'email' => $input['email'],
                'address' => $input['address'],
                'birth_date' => $input['bdate']
            ]);
            App\UserInfo::insert(['user_id' => $user_id, 'personal_info_id' => $personal_id]);
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            Log::info($e->getMessage());
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return json_encode($data);
    }

    public function showModal()
    {
        return view('modals/users');
    }

    public function retrieve()
    {
        $status = FALSE;
        DB::connection()->enableQueryLog();
        try
        {
            // join('table_name', '')
            $data['users'] = App\User::leftJoin('user_info AS A', 'users.id', '=', 'A.user_id')
            ->leftJoin('personal_info AS B', 'A.personal_info_id', '=', 'B.id')->get();
            $status = TRUE;
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }

        // Log::info(json_encode(DB::getQueryLog()));
        $data['status'] = $status;
        return $data;
    }

    public function update(Request $input)
    {

    }

    public function delete()
    {

    }

    public function login()
    {
        $credentials = Request::all();

        if (Auth::attempt($credentials)) {
            return array('status' => true);
        } else {
            return array('status' => false);
        }
    }
}
