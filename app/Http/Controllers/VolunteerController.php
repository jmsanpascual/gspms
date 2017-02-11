<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Volunteer;
use App\User;
use App\PersonalInfo;
use App\UserInfo;
use Response;
use Hash;
use Lang;
use Log;
use DB;

class VolunteerController extends Controller
{
    protected $roleId = 6;

    public function index()
    {
        $roleId = $this->roleId;

        try {
            $volunteers = User::with(['infos', 'roles', 'expertises'])
                ->whereHas('roles', function ($query) use($roleId) {
                    $query->where('role_id', $roleId);
                })->get();

            return Response::json($volunteers);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function create()
    {
        return view('modals/volunteers');
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = '';

        try {
            $volunteer = $request->get('volunteer');
            $personalInfo = $volunteer['info'];
            $expertise = $volunteer['expertise'];
            unset($volunteer['info']);
            unset($volunteer['expertise']);

            $volunteer = new User($volunteer);
            $personalInfo = new PersonalInfo($personalInfo);

            DB::beginTransaction();

            $volunteer->save();
            $volunteer->infos()->save($personalInfo);
            $volunteer->roles()->attach($this->roleId);
            $volunteer->expertises()->attach($expertise['id']);

            DB::commit();

            $data['volunteerId'] = $volunteer->id;
            $data['personalInfoId'] = $personalInfo->id;
            $status = true;
            $msg = Lang::get('notifications.data_saved');
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function show($id)
    {

        try {
            $volunteer = User::with(['infos', 'roles'])
                ->where('id', $id)->first();

            return Response::json($volunteer);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $volunteer = $request->get('volunteer');
            $volunteerId = $volunteer['id'];
            $volunteerInstance = User::find($volunteerId);
            $personalInfo = $volunteer['info'];
            $personalInfoId = $personalInfo['id'];
            $expertise = $volunteer['expertise'];

            unset($volunteer['info']);
            unset($volunteer['role']);
            unset($volunteer['expertise']);
            unset($personalInfo['pivot']);

            DB::beginTransaction();

            if (EMPTY($volunteer['password'])) {
                $volunteer['password'] = $volunteerInstance->password;
            } else {
                $volunteer['password'] = Hash::make($volunteer['password']);
            }

            User::where('id', $volunteerId)->update($volunteer);
            PersonalInfo::where('id', $personalInfoId)->update($personalInfo);
            $volunteerInstance->expertises()->sync([$expertise['id']]);

            DB::commit();

            return Response::json(['result' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         User::where('id', $id)->delete();
    //         return Response::json(true);
    //     } catch (\Exception $e) {
    //         return Response::json(['error' => $e->getMessage()]);
    //     }
    // }
}
