<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App;
use Log;
use DB;
use Request;
use Hash;
use Auth;
use Lang;
use Response;
class UserController extends Controller
{

    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

    public function index()
    {
        return view('users');
    }

    public function getResourcePerson()
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $user_info = (new App\UserInfo)->getTable();
            $personal_info = (new App\PersonalInfo)->getTable();
            $data['resource_persons'] = App\PersonalInfo::joinUserInfo()->whereNull($user_info.'.user_id')
                                ->select($personal_info . '.id', 
                                    DB::raw('CONCAT(last_name,", ",first_name, " ",middle_name) AS name'))->get();
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

    public function getChampion()
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $personal_info = (new App\PersonalInfo)->getTable();
            $data['champions'] = App\User::joinUserRole()->joinPersonalInfo()
                                ->where('role_id', config('constants.role_champion'))
                                ->select($personal_info . '.id', 
                                    DB::raw('CONCAT(last_name,", ",first_name, " ",middle_name) AS name'))->get();
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

    public function getRoles()
    {
        try
        {
            $data['roles'] = App\Roles::select('id', 'name')->get();

            return json_encode($data);
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }
    }

    public function create()
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $input = Request::get('users');
            // $input = $input['users'];
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
            App\UserRoles::insert(['role_id' => $input['selectedRole'], 'user_id' => $user_id]);
            DB::commit();
            $status = TRUE;
            $msg = Lang::get('notifications.data_saved');
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

    // single user
    public function retrieveUser($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $token = csrf_token();
            Log::info('token' . $token);
            $data['roles'] = App\Roles::select('id', 'name')->get();
            $data['users'] = App\User::leftJoin('user_roles AS B', 'users.id', '=', 'B.user_id')
            ->leftJoin('user_info AS C', 'users.id', '=', 'C.user_id')
            ->leftJoin('personal_info AS D', 'C.personal_info_id', '=', 'D.id')
            ->select('users.id', 'users.username', 'B.role_id AS selectedRole', 'D.first_name AS fname',
             'D.middle_name AS mname', 'D.last_name AS lname', 'D.contact_num AS cnum',
'D.email', 'D.address', 'D.birth_date AS bdate', DB::Raw('"'. $token . '" AS token'))
            ->where('users.id', $id)->first();

            $status = TRUE;
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }
        Log::info('line 129  -- - - ');
        Log::info(json_encode(DB::getQueryLog()));
        $data['status'] = $status;
        $data['msg'] = $msg;

        return json_encode($data);
    }

    // user list
    public function retrieve()
    {
        $status = FALSE;
        try
        {
            // join('table_name', '')
            $data['users'] = App\User::leftJoin('user_info AS A', 'users.id', '=', 'A.user_id')
            ->leftJoin('personal_info AS D', 'A.personal_info_id', '=', 'D.id')->
            select( 'users.id', 'users.username', 'D.first_name AS fname',
             'D.middle_name AS mname', 'D.last_name AS lname', 'D.contact_num AS cnum',
            'D.email', 'D.address', 'D.birth_date', DB::raw('CONCAT(D.first_name, " ", D.last_name) as fullName'))
            ->get();
            $status = TRUE;
             Log::info(json_encode(DB::getQueryLog()));
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }

        // Log::info(json_encode(DB::getQueryLog()));
        $data['status'] = $status;
        return $data;
    }

    public function update()
    {
       $status = FALSE;
        $msg = '';
        try
        {
            $input = Request::get('users');
            Log::info('update');

            Log::info(json_encode($input));
            Log::info(json_encode($input['username']));

            // check if username or email already exist w/c is not yet deleted
            $result = App\User::leftJoin('user_info AS A', 'users.id', '=', 'A.user_id')
            ->leftJoin('personal_info AS B', 'A.personal_info_id', '=', 'B.id')
            ->where(function($query) use ($input) {
                $query->where('users.username', $input['username'])
                ->orWhere('B.email', $input['email']);
            })
            ->where('users.id', '!=', $input['id']) // not equal to itself
            ->whereNull('users.deleted_at')
            ->whereNull('B.deleted_at')
            ->count();


            if($result > 0)
            {
                // throw new Exception('username or email already exist');
            }
            $users = array('username' => $input['username']);
            if(!EMPTY($input['password']))
                $users['password'] = Hash::make($input['password']);

            DB::beginTransaction();
            App\User::where('id', $input['id'])->update($users);

            $p_id = App\UserInfo::where('user_id', $input['id'])->select('personal_info_id')->first();

            $personal_id = App\PersonalInfo::where('id', $p_id->personal_info_id)->update([
                'first_name' => $input['fname'],
                'middle_name' => $input['mname'],
                'last_name' => $input['lname'],
                'contact_num' => $input['cnum'],
                'email' => $input['email'],
                'address' => $input['address'],
                'birth_date' => $input['bdate']
            ]);
            App\UserRoles::where('user_id', $input['id'])->update(['role_id' => $input['selectedRole']]);
            DB::commit();
            $status = TRUE;
            $msg = Lang::get('notifications.data_saved');
        }
        catch(Exception $e)
        {
            DB::rollback();
            Log::info(json_encode(DB::getQueryLog()));
            Log::info($e->getMessage());
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return json_encode($data);
    }

    public function delete($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            DB::beginTransaction();
            Log::info($id);
            App\User::where('id', $id)->delete();
            $p_id = App\UserInfo::where('user_id', $id)->select('personal_info_id')->first();
            Log::info('line 237');
            Log::info($p_id);
            App\PersonalInfo::where('id', $p_id->personal_info_id)->delete();
            DB::commit();
            $status = TRUE;

        }
        catch(Exception $e)
        {
            DB::rollback();

            Log::info($e->getMessage());
            $msg = $e->getMessage();
        }
         Log::info(json_encode(DB::getQueryLog()));
        $data['status'] = $status;
        $data['msg'] = $msg;

        return json_encode($data);
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
