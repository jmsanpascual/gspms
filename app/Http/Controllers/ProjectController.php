<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Response;
use Log;
use DB;
use Session;
use Exception;

class ProjectController extends Controller
{

    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }

    public function index($related = NULL)
    {
        $status = FALSE;
        $msg = '';
        $data = array();

        try
        {
            $proj = (new App\Projects)->getTable();
            $stat = (new App\ProjectStatus)->getTable();
            Log::info('line 24 - - - -');
            Log::info($proj);
            $token = csrf_token();
            $data['proj'] = App\Projects::JoinStatus();


            $select = [
                $proj . '.name',
                $stat . '.name AS status',
                $proj . '.id',
                'start_date',
                'end_date',
                'objective',
                'total_budget',
                'champion_id',
                'program_id',
                'proj_status_id',
                'resource_person_id',
                'partner_organization',
                'partner_community',
                DB::Raw('"'. $token . '" AS token')
            ];

            // search related projects
            if(!EMPTY($related)) {
                // find related projects within 5 years
                $getMinYear = date('Y-m-d H:i:s', strtotime('-5 years'));
                // make this check approved
                // $select[] = DB::Raw('MAX(proj_budget_request.amount) as max_budget');
                // $select[] = DB::Raw('MIN(proj_budget_request.amount) as min_budget');

                $data['proj']
                // ->leftJoin('proj_budget_request', 'proj_budget_request.proj_id', '=', 'projects.id')
                ->where('program_id', $related->program_id)
                //   ->where($proj.'.created_at', '>', $getMinYear)
                  ->Where($proj.'.end_date', '>', $getMinYear)
                  ->whereIn('proj_status_id', [1,3,5])
                  ->where($proj.'.id', '!=', $related->id);
            }

            $data['proj'] = $data['proj']->get($select);

            foreach($data['proj'] as $key => $value) {
                $temp = explode('(#$;)', $value->objective);
                $data['proj'][$key]->objective = $temp;

                if(!EMPTY($related)) {
                    // start date
                    $start_year = date('Y', strtotime($data['proj'][$key]->start_date));
                    // $start_month = date('n', strtotime($data['proj'][$key]->start_date));
                    // $start_day = date('j', strtotime($data['proj'][$key]->start_date));

                    // end date
                    $end_year = date('Y', strtotime($data['proj'][$key]->end_date));
                    // $end_month = date('n', strtotime($data['proj'][$key]->end_date));
                    // $end_day = date('j', strtotime($data['proj'][$key]->end_date));

                    $duration_year = ($end_year - $start_year) . 'year(s) ';
                    // $duration_month = ($end_month - $start_month) . 'month(s) ';
                    // $duration_day = ($end_month - $start_month) . 'month(s) ';
                    $data['proj'][$key]->duration = $duration_year;
                }
            }

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

    public function create()
    {
        return view('create-project');
    }

    public function show()
    {
        return view('modals/projects');
    }

    public function fetchProj($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $token = csrf_token();
            $data['proj'] = App\Projects::select('id', 'name', 'start_date','end_date', 'objective',
                'total_budget', 'champion_id', 'program_id', 'proj_status_id', 'resource_person_id',
                'partner_organization', 'partner_community', DB::Raw('"'. $token . '" AS token'))
            ->where('id', $id)->first();
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

    public function store(Request $request)
    {
        $status = FALSE;
        $msg = '';
        $temp = ''; // Holds the new concatenated objectives
        $delimiter = '(#$;)'; // Used for concatenation of objectives

        try {
            $project = $request->all();
            logger('projects');
            logger($project);
            $objectives = $project['objective']; // Store the array objectives
            unset($project['token']);

            // Convert array obkectives to concatenated string using the delimiter
            foreach($project['objective'] as $key => $value) {
               if (empty($temp)) $temp .= $value;
               else $temp .= $delimiter . $value;
            }

            $project['objective'] = $temp;
            $project['proj_status_id'] = 2; // FOR APPROVAL
            if(EMPTY($project['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $project['champion_id'] = Session::get('id');

            $project['start_date'] = date('Y-m-d H:i:s', strtotime($project['start_date']));
            Log::info(' start date '. $project['start_date']);
            $project['end_date'] = date('Y-m-d H:i:s', strtotime($project['end_date']));
            $project['id'] = App\Project::insertGetId($project);
            // Get status name
            $stat_name = App\ProjectStatus::where('id', $project['proj_status_id'])->value('name');

            $project['objective'] = $objectives; // Reassign the array objectives
            $data['proj'] = $project;
            $data['proj']['proj_status_id'] = $project['proj_status_id'];
            $data['proj']['status'] = $stat_name;
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
        $temp = ''; // Holds the new concatenated objectives
        $delimiter = '(#$;)'; // Used for concatenation of objectives

        try {
            $request = $request->all();
            $id = $request['id'];
            $upd_arr = $request;
            unset($upd_arr['id']);
            unset($upd_arr['status']);
            unset($upd_arr['token']);

            // Convert array objectives to concatenated string using the delimiter
            foreach($upd_arr['objective'] as $key => $value) {
               if (empty($temp)) $temp .= $value;
               else $temp .= $delimiter . $value;
            }

            $upd_arr['objective'] = $temp; // Assign the concatenated objectives
            unset($upd_arr['status_id']);
            $upd_arr['proj_status_id'] = 2;
            if(EMPTY($upd_arr['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $upd_arr['champion_id'] = Session::get('id');
            $upd_arr['start_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['start_date']));
            Log::info(' start date '. $upd_arr['start_date']);
            $upd_arr['end_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['end_date']));
            App\Projects::where('id', $id)->update($upd_arr);
            $stat = App\ProjectStatus::where('id', $upd_arr['proj_status_id'])->value('name');
            $data['proj'] = $request;
            $data['proj']['proj_status_id'] = $upd_arr['proj_status_id'];
            $data['proj']['status'] = $stat;
            $status = TRUE;
        } catch(Exception $e) {
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function approveStatus(Request $req)
    {
        $msg = '';
        $status = FALSE;
        try {
            // fetch the highest budget and lowest budget with same category

            return view();
        } catch(\Exception $e) {
            Log::info(json_encode(DB::getQueryLog()));
            $msg = $e->getMessage();
        }

        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

    public function updateStatus(Request $req)
    {
        $msg = '';
        $status = FALSE;
        try
        {
            // missing check if for approval
            $stat = App\Project::where('id', $req->get('proj_id'))
            ->update([
                'proj_status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ]);

            $data['stat'] = App\ProjectStatus::where('id', $req->get('id'))->first(['id','name']);
            Log::info('stat' . json_encode($data['stat']));
            $status = TRUE;
        }
        catch(Exception $e)
        {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

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

            App\Projects::where('id', $id)->delete();
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

    public function report($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
            ->leftJoin('personal_info AS rp', 'rp.id', '=', 'projects.resource_person_id')
            ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
            ->leftJoin('user_info', 'user_info.user_id','=','users.id')
            ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
            ->where('projects.id', $id)->first(['projects.*','programs.name AS program',
                DB::raw('CONCAT(rp.first_name, " ", rp.middle_name, " ", rp.last_name) AS rp_name'),
                DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')]);

            $data['total_expense'] = App\ProjectItemCategory::where('proj_id', $id)
            ->sum(DB::raw('quantity * price'));

            $data['proj_id'] = $id;
            // $data['chart'] = $this->createChart($id);
            $html = view('reports/project', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();
            $pdf->writeHTML($html);
            $pdf->SetFooter('Generated date: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function createChart($id)
    {
        Log::info('create chart');
        header("Content-type: image/png");

        $chart = new \PieChart(500, 260);

        $dataSet = new \XYDataSet();
        $dataSet->addPoint(new \Point("tessst", 80));
        $dataSet->addPoint(new \Point("eyayt", 12));
        $dataSet->addPoint(new \Point("ababa", 8));
        $chart->setDataSet($dataSet);

        $chart->setTitle(" TESTING . com - - - ");
        return $chart->render('test.png');
    }

    public function getRelated($id) {
        $status = FALSE;
        $msg = '';
        try {
            $proj = App\Project::find($id);
            $data['related'] = $this->index($proj)[0]['proj'];
            $status = TRUE;
        } catch(Exception $e) {
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return $data;
    }
}
