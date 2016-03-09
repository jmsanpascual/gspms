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
                'rp.id', 'rp.profession', 'pi.first_name',
                'pi.last_name', 'pi.contact_num',
                'pi.email', 'pi.address', 's.name as school',
                DB::raw('CONCAT(pi.first_name, " ", pi.last_name) as name')
            )->join('personal_info as pi', 'pi.id', '=', 'rp.personal_info_id')
            ->join('schools as s', 's.id', '=', 'rp.school_id')->get();

            return Response::json($resourcePersons);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function create()
    {
        return view('create-resource-person');
    }

    public function store(Request $request)
    {
        try {
            $personalInfo = $request->get('personalInfo'); // Personal info
            $resourcePerson = $request->get('resourcePerson'); // Resource person info

            // Insert the personal info and get the id
            $personalInfoId = PersonalInfo::insertGetId($personalInfo);
            $resourcePerson['personal_info_id'] = $personalInfoId;

            ResourcePerson::insert($resourcePerson);
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }
}
