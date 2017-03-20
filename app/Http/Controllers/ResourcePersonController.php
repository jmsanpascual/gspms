<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ResourcePerson;
use App\PersonalInfo;
use Response;
use Log;
use DB;

class ResourcePersonController extends Controller
{
    public function index()
    {
        try {
            $resourcePersons = ResourcePerson::select(
                'resource_persons.id', 'resource_persons.profession',
                'resource_persons.personal_info_id', 'pi.first_name',
                'pi.last_name', 'pi.contact_num', 'pi.email', 'pi.address',
                's.name as school', 's.id as school_id',
                DB::raw('CONCAT(pi.first_name, " ", pi.last_name) as name')
            )->join('personal_info as pi', 'pi.id', '=',
            'resource_persons.personal_info_id')
            ->join('schools as s', 's.id', '=',
            'resource_persons.school_id')->get();

            return Response::json($resourcePersons);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function getResourcePersons(Request $request)
    {
        try {
            $resourcePerson = ResourcePerson::select(
                'resource_persons.id',
                DB::raw('CONCAT(pi.first_name, " ", pi.last_name) as name')
            )->join('personal_info as pi', 'pi.id', '=',
            'resource_persons.personal_info_id')
            ->join('specializations as sp', 'sp.resource_person_id', '=', 'resource_persons.id');

            if($request->program_id)
                $resourcePerson->where('sp.program_id', $request->program_id);

            $resourcePerson = $resourcePerson->groupBy('resource_persons.id')->get();

            return $resourcePerson;
        } catch(Exception $e) {
            logger($e);
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function create()
    {
        return view('modals/resource-person');
    }

    public function store(Request $request)
    {
        try {
            $personalInfo = $request->get('personalInfo'); // Personal info
            $resourcePerson = $request->get('resourcePerson'); // Resource person info

            // Insert the personal info and get the id
            $personalInfoId = PersonalInfo::insertGetId($personalInfo);
            $resourcePerson['personal_info_id'] = $personalInfoId;

            $resourcePersonId = ResourcePerson::insertGetId($resourcePerson);
            $resourcePerson['id'] = $resourcePersonId;

            // $person = [
            //     'personalInfo' => $personalInfo,
            //     'resourcePerson' => $resourcePerson
            // ];

            // return Response::json($person);
            return Response::json(['id' => $resourcePersonId, 'personal_info_id' => $personalInfoId]);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $resourcePerson = ResourcePerson::where('id', $id)->first();
            return Response::json($resourcePerson);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $unsetArr = ['name', 'profession', 'school', 'personal_info_id', 'school_id'];
            $personalInfo = $request->get('personalInfo'); // Personal info
            $resourcePerson = $request->get('resourcePerson'); // Resource person info
            $resourceId = $resourcePerson['id'];
            unset($resourcePerson['id']);

            $personalInfo['id'] = $personalInfo['personal_info_id'];

            for ($i = 0; $i < count($unsetArr); $i++) {
                if (isset($personalInfo[$unsetArr[$i]])) {
                    unset($personalInfo[$unsetArr[$i]]);
                }
            }
            PersonalInfo::where('id', $personalInfo['id'])->update($personalInfo);
            $rPerson = ResourcePerson::find($resourceId);
            ResourcePerson::where('id', $resourceId)->update($resourcePerson);

            return Response::json(['result' => true]);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            ResourcePerson::where('id', $id)->delete();
            return Response::json(true);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }
}
