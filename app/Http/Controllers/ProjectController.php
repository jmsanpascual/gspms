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
use App\Notification;
use App\UserNotification;
use App\UserRoles;
use App\Traits\Notify;
use Carbon\Carbon;
use App\Fund;

class ProjectController extends Controller
{
    use Notify;

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
                'remarks',
                DB::Raw('"'. $token . '" AS token')
            ];

            // search related projects
            if(!EMPTY($related)) {
                // find related projects within 5 years
                $getMinYear = date('Y-m-d H:i:s', strtotime('-5 years'));
                // make this check approved
                // $select[] = DB::Raw('MAX(proj_budget_request.amount) as max_budget');
                // $select[] = DB::Raw('MIN(proj_budget_request.amount) as min_budget');
                $projStatusAllowed = [
                    config('constants.proj_status_ongoing'),
                    config('constants.proj_status_completed'),
                    config('constants.proj_status_approved'),
                ];

                $data['proj']
                // ->leftJoin('proj_budget_request', 'proj_budget_request.proj_id', '=', 'projects.id')
                ->where('program_id', $related->program_id)
                //   ->where($proj.'.created_at', '>', $getMinYear)
                  ->where($proj.'.end_date', '>', $getMinYear)
                  ->whereIn('proj_status_id',$projStatusAllowed)
                  ->where($proj.'.id', '!=', $related->id);
            } else if(EMPTY($related)) {
                // if exec or champion show only projects that are ongoing, disapprove and approve
                // showed disapprove for them to edit it and ask for approval again
                if(Session::get('role') == config('constants.role_champion')
                    || Session::get('role') == config('constants.role_exec')) {

                    $projStatusAllowed = [
                        config('constants.proj_status_ongoing'),
                        config('constants.proj_status_disapproved'),
                        config('constants.proj_status_approved'),
                    ];
                    $data['proj']->whereIn('proj_status_id', $projStatusAllowed);

                    // if champion only show assigned projects
                    if(Session::get('role') == config('constants.role_champion')) {
                        $data['proj']->where('champion_id', Session::get('id'));
                    }

                // if life, head or finance dont show ongoing projects
                } else if(Session::get('role') == config('constants.role_head')
                    || Session::get('role') == config('constants.role_life')
                    || Session::get('role') == config('constants.role_finance')) {

                    // $data['proj']->where('proj_status_id', '!=', config('constants.proj_status_ongoing'));
                }
            }

            $data['proj'] = $data['proj']->get($select);
            $min_duration = 0;
            $max_duration = 0;
            $ave_duration = 0;

            foreach($data['proj'] as $key => $value) {
                $temp = explode('(#$;)', $value->objective);
                $data['proj'][$key]->objective = $temp;

                if(!EMPTY($related)) {
                    $start_date =  Carbon::createFromFormat('Y-m-d H:i:s', $data['proj'][$key]->start_date);
                    $end_date =  Carbon::createFromFormat('Y-m-d H:i:s', $data['proj'][$key]->end_date);
                    $days = $end_date->diffInDays($start_date);
                    $duration = $this->_convertToYearMonthDays($days);

                    $ave_duration += $days;
                    $max_duration = ($days > $max_duration) ? $days : $max_duration;
                    $min_duration = ($days < $min_duration || $min_duration === 0) ? $days : $min_duration;

                    $data['proj'][$key]->duration = $duration;
                }
            }

            if(!EMPTY($related)) {
                // logger('computing');
                $ave_duration = $ave_duration/$data['proj']->count();
                $data['others'] = [
                    'ave_duration' => $this->_convertToYearMonthDays($ave_duration),
                    'min_duration' => $this->_convertToYearMonthDays($min_duration),
                    'max_duration' => $this->_convertToYearMonthDays($max_duration)
                ];
            }

            $status = TRUE;
        }
        catch(Exception $e)
        {
            logger($e->getError());
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return array($data);
    }

    public function _convertToYearMonthDays($days)
    {
        $yearMonths = 12;
        $monthDays = 365.25/$yearMonths;
        $months = 0;
        $years = 0;

        // convert to month
        if($days > $monthDays) {
            $months = floor($days/$monthDays);
            // get the remainder
            $days = $days % $monthDays;
        }

        // convert to years
        if($months > $yearMonths) {
            $years = floor($months/$yearMonths);
            //get the remainder for months
            $months = $months%$yearMonths;
        }

        $format = $years . ' yr(s). '. $months . ' mo(s). ';

        return $format;
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
            // logger('projects');
            // logger($project);
            $objectives = $project['objective']; // Store the array objectives
            unset($project['token']);
            if($project['resource_person_id'] == 'NA')
                $project['resource_person_id'] = NULL;
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
            $project['end_date'] = date('Y-m-d H:i:s', strtotime($project['end_date']));
            $project['id'] = App\Project::insertGetId($project);
            // if the one adding is not the champion notify the champion about the added project
            if(Session::get('role') != config('constants.role_champion'))
                $this->_notifyAssignedChampion($project);

            $this->_notifyFinance($project);
            // Get status name
            $stat_name = App\ProjectStatus::where('id', $project['proj_status_id'])->value('name');

            $project['objective'] = $objectives; // Reassign the array objectives
            $data['proj'] = $project;
            $data['proj']['proj_status_id'] = $project['proj_status_id'];
            $data['proj']['status'] = $stat_name;
            $data['saveUrl'] = 'update';
            $status = TRUE;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }

        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

    private function _notifyFinance($proj, $edit = FALSE)
    {
        try {
            // logger($proj);
            if($proj['proj_status_id'] != config('constants.proj_status_for_approval_finance')) return;

            if($edit) {
                // notify finance of edited project
                $finance = config('constants.role_finance');
                $finance_emp = UserRoles::where('role_id', $finance)->lists('user_id');

                $data = [
                    'title' => 'Project Edited',
                    'text' => trans('notifications.project_edited', ['name' => $proj['name']]),
                    'proj_id' => $proj['id'],
                    'user_ids' => $finance_emp
                ];

                return $this->saveNotif($data);
            }

            $finance = config('constants.role_finance');
            $finance_emp = UserRoles::where('role_id', $finance)->lists('user_id');
            logger($finance_emp);
            $data = [
                'title' => 'Project Newly Added',
                'text' => trans('notifications.project_added', ['name' => $proj['name']]),
                'proj_id' => $proj['id'],
                'user_ids' => $finance_emp
            ];

            $this->saveNotif($data);
        } catch(Exception $e) {
            throw $e;
        }

    }

    private function _notifyAssignedChampion($proj, $previous_champion = NULL)
    {
        try {
            if(!EMPTY($previous_champion)) {
                $data = [
                    'title' => 'Project Assignment Removed',
                    'text' => trans('notifications.project_assigned_remove', ['name' => $proj['name']]),
                    'proj_id' => $proj['id'],
                    'user_ids' => [$previous_champion]
                ];

                $this->saveNotif($data);

            }

            $data = [
                'title' => 'Project Assignment',
                'text' => trans('notifications.project_assigned', ['name' => $proj['name']]),
                'proj_id' => $proj['id'],
                'user_ids' => [$proj['champion_id']]
            ];

            $this->saveNotif($data);
        } catch (Exception $e) {
            throw $e;
        }
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

            if($upd_arr['resource_person_id'] == 'NA')
                $upd_arr['resource_person_id'] = NULL;

            // Convert array objectives to concatenated string using the delimiter
            foreach($upd_arr['objective'] as $key => $value) {
               if (empty($temp)) $temp .= $value;
               else $temp .= $delimiter . $value;
            }
            $previous_champion = App\Projects::find($id)->champion_id;
            $upd_arr['objective'] = $temp; // Assign the concatenated objectives
            unset($upd_arr['status_id']);
            $upd_arr['proj_status_id'] = 2;
            if(EMPTY($upd_arr['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $upd_arr['champion_id'] = Session::get('id');

            $upd_arr['start_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['start_date']));
            $upd_arr['end_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['end_date']));
            App\Projects::where('id', $id)->update($upd_arr);

            $stat = App\ProjectStatus::where('id', $upd_arr['proj_status_id'])->value('name');
            $data['proj'] = $request;
            $data['proj']['proj_status_id'] = $upd_arr['proj_status_id'];
            $data['proj']['status'] = $stat;

            // if the one updating is not the champion and selected champion has been changed
            // notify the champion about the new project assigned
            if(Session::get('role') != config('constants.role_champion')
                && $previous_champion != $data['proj']['champion_id'])
                $this->_notifyAssignedChampion($data['proj'], $previous_champion);

            $this->_notifyFinance($data['proj'], true);
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
            DB::beginTransaction();
            $proj = App\Project::where('id',$req->get('proj_id'));
            $findProj = $proj->first();
            $this->_addNotif($req, $findProj);
            $this->_deductFund($req, $findProj);
            $this->_addNotifFinance($req, $findProj);
            $this->_addNotifLife($req, $findProj);
            $this->_completedProj($req, $findProj);
            // logger($req);
            // missing check if for approval
            $stat = $proj->update([
                'proj_status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ]);

            $data['stat'] = App\ProjectStatus::where('id', $req->get('id'))->first(['id','name']);
            // Log::info('stat' . json_encode($data['stat']));
            $status = TRUE;

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            logger($e);
            $msg = $e->getMessage();
        }
        $data['msg'] = $msg;
        $data['status'] = $status;

        return Response::json($data);
    }

    public function _addNotifFinance($req, $proj)
    {
        if($proj['proj_status_id'] != config('constants.proj_status_for_approval_finance')) return;
        try {
            // notify finance of edited project
            $finance = config('constants.role_finance');
            $finance_emp = UserRoles::where('role_id', $finance)->lists('user_id');

            $data = [
                'title' => 'Project Approval',
                'text' => trans('notifications.project_approval', ['name' => $proj->name]),
                'proj_id' => $proj->id,
                'user_ids' => $finance_emp
            ];

            $this->saveNotif($data);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function _completedProj($req, $proj)
    {
        if($req->id != config('constants.proj_status_completed')) return;
        // if project  completed check for remaining budget and add it in the current year funds
        try {
            $total_expense = App\ProjectItemCategory::where('proj_id', $proj['id'])
            ->sum(DB::raw('quantity * price'));
            $remaining_funds = $proj['total_budget'] - $total_expense;

            $year = date('Y');

            $ins = [
                'project_id' => $proj['id'],
                'amount' => $remaining_funds,
                'year' => $year,
                'received_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            App\ProjectFund::insert($ins);
            // update remaining funds
            App\Fund::where('year', $year)->increment('remaining_funds', $remaining_funds);

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function _addNotifLife($req, $proj)
    {
        if($proj['proj_status_id'] != config('constants.proj_status_for_approval_life')) return;
        // if project  completed notify except champion
        try {
            // notify finance of edited project
            $role = config('constants.role_life');
            $user_ids = UserRoles::where('role_id', $role)->lists('user_id');

            $data = [
                'title' => 'Project Approval',
                'text' => trans('notifications.project_approval', ['name' => $proj->name]),
                'proj_id' => $proj->id,
                'user_ids' => $user_ids
            ];

            $this->saveNotif($data);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function _deductFund($req, $proj)
    {
        // it means that it was approved by finance
        $status = config('constants.proj_status_approved');
        if($req->id != $status) return;
        // if approved by finance deduct funds
        try {
            if(EMPTY($proj->total_budget)) throw new Exception('Total Budget is missing on approve.');

            // get year today
            $year = date('Y');
            $fund = Fund::where('year', $year)->first();

            if(EMPTY($fund)) throw new Exception('No Funds yet on this year');
            if($fund->remaining_funds < $proj->total_budget) throw new Exception('Insufficient funds on requested budget.');

            $fund->remaining_funds -= $proj->total_budget;
            $fund->save();

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function _addNotif($req, $proj)
    {
        $status = config('constants.proj_status_completed');
        if($req->id != $status) return;
        // if project  completed notify except champion
        try {
            $data = [
                'title' => 'Project Completed',
                'text' => trans('notifications.proj_completed', ['name' => $proj->name]),
                'proj_id' => $proj->id,
                'role' => config('constants.role_champion'),
            ];

            $this->saveNotif($data);
        } catch(Exception $e) {
            throw $e;
        }
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

            $start_date =  Carbon::createFromFormat('Y-m-d H:i:s',$data['proj']->start_date);
            $end_date =  Carbon::createFromFormat('Y-m-d H:i:s', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);
            $data['duration'] = $this->_convertToYearMonthDays($days);

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
            $index = $this->index($proj)[0];
            $data['related'] = $index['proj'];
            $data['others'] = $index['others'];
            $status = TRUE;
        } catch(Exception $e) {
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return $data;
    }

    public function getOnGoingProjects()
    {
        $projects = App\Projects::where('proj_status_id', '1')->get();
        return Response::json($projects);
    }
}
