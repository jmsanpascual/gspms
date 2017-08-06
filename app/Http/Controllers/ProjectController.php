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
use Anam\PhantomMagick\Converter;

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
                        config('constants.proj_status_incomplete'),
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
            // if want to get delayed projects
            // if($request->delayed) {
            //     // get where end date is less than today
            //     $data['proj'] = $data['proj']->where('end_date', '<', date('Y-m-d H:i:s'))
            //     // and project status is not completed
            //                     ->where('proj_status_id', config('constants.proj_status_completed'));
            // }

            $data['proj'] = $data['proj']->get($select);
            $min_duration = 0;
            $max_duration = 0;
            $ave_duration = 0;

            foreach($data['proj'] as $key => $value) {
                $temp = explode('(#$;)', $value->objective);
                $data['proj'][$key]->objective = $temp;


                    $start_date =  Carbon::createFromFormat('Y-m-d', $data['proj'][$key]->start_date);
                    $end_date =  Carbon::createFromFormat('Y-m-d', $data['proj'][$key]->end_date);
                    $days = $end_date->diffInDays($start_date);
                    $duration = $this->_convertToYearMonthDays($days);

                if(!EMPTY($related)) {
                    $ave_duration += $days;
                    $max_duration = ($days > $max_duration) ? $days : $max_duration;
                    $min_duration = ($days < $min_duration || $min_duration === 0) ? $days : $min_duration;

                    $addedBudget = App\ProjectBudgetRequest::where('proj_id', $value->id)
            			// 2 = approve
            			->where('status_id', 2)->sum('amount');
                    $expenses =  App\ProjectExpense::where('proj_id', $value->id)->sum('amount');

                    // get current budget
                    $data['proj'][$key]->current_budget = number_format(($value->total_budget + $addedBudget) - $expenses, 2, '.', '');

                    $data['proj'][$key]->projectexpense = App\ProjectExpense::where('proj_id', $value->id)->get();
                }

                $data['proj'][$key]->duration = $duration;

                // get program name
                $program = App\Program::find($data['proj'][$key]->program_id);
                $data['proj'][$key]->program_name = ($program) ? $program->name : '';
                // get champion name
                $user = App\PersonalInfo::find($data['proj'][$key]->champion_id);
                $fullName = ($user) ? $user->last_name.', '.$user->first_name.' '.$user->middle_name : '';
                $data['proj'][$key]->champion_name = $fullName;
            }

            if(!EMPTY($related)) {
                // logger('computing');
                $ave_duration = $ave_duration/($data['proj']->count() || 1);
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
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return array($data);
    }

    public function upcoming(Request $request)
    {
        try{
            $proj = (new App\Projects)->getTable();
            $stat = (new App\ProjectStatus)->getTable();
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
                'remarks'
            ];

            // $projStatusAllowed = [
            //     config('constants.proj_status_ongoing'),
            //     config('constants.proj_status_disapproved'),
            //     config('constants.proj_status_approved'),
            //     config('constants.proj_status_incomplete'),
            // ];

            // $data['proj']->whereIn('proj_status_id', $projStatusAllowed);
            $data['proj'] = $data['proj']->where('start_date', '>', date('Y-m-d H:i:s'))->get($select);
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
        }

        return $data;
    }

    public function delayed(Request $request)
    {
        try{
            $proj = (new App\Projects)->getTable();
            $stat = (new App\ProjectStatus)->getTable();
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
                'remarks'
            ];

            // $projStatusAllowed = [
            //     config('constants.proj_status_ongoing'),
            //     config('constants.proj_status_disapproved'),
            //     config('constants.proj_status_approved'),
            //     config('constants.proj_status_incomplete'),
            // ];

            // $data['proj']->whereIn('proj_status_id', $projStatusAllowed);
            $data = $data['proj']->where(function($query){
                //delayed projects
                $query->where('proj_status_id', '!=', config('constants.proj_status_completed'))
                    ->where('end_date', '<', date('Y-m-d H:i:s'));
            })
            // completed but delayed
                ->orWhere(function($query){
                $query->where('proj_status_id', config('constants.proj_status_completed'))
                    ->where('end_date', '<', DB::raw('actual_end'));
            })->get($select);

            foreach($data as $key => $value) {
                $temp = explode('(#$;)', $value->objective);
                $data[$key]->objective = $temp;
            }
        } catch(Exception $e) {
            logger($e);
            $msg = $e->getMessage();
        }

        return $data;
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
            $project['proj_status_id'] = config('constants.proj_status_incomplete'); // Incomplete
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
            $previous_proj = App\Projects::find($id);
            $previous_champion = $previous_proj->champion_id;

            $upd_arr['objective'] = $temp; // Assign the concatenated objectives
            unset($upd_arr['status_id']);
            if($previous_proj->proj_status_id != config('constants.proj_status_approved') &&
                $previous_proj->proj_status_id != config('constants.proj_status_incomplete'))
                $upd_arr['proj_status_id'] = config('constants.proj_status_for_approval_finance');

            if(EMPTY($upd_arr['champion_id'])  && Session::get('role') == config('constants.role_champion'))
                $upd_arr['champion_id'] = Session::get('id');

            $upd_arr['start_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['start_date']));
            $upd_arr['end_date'] = date('Y-m-d H:i:s', strtotime($upd_arr['end_date']));
            App\Projects::where('id', $id)->update($upd_arr);

            $stat = App\ProjectStatus::where('id', $upd_arr['proj_status_id'])->value('name');
            $data['proj'] = $request;

            if(EMPTY($upd_arr['remarks']))
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
            $upd_params = [
                'proj_status_id' => $req->get('id'),
                'remarks' => $req->get('remarks')
            ];
            if($req->id == config('constants.proj_status_completed')) {
                // if completed add acutal end on update
                $upd_params['actual_end'] = date('Y-m-d H:i:s');
            }

            $stat = $proj->update($upd_params);

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
            $total_expense = App\ProjectExpense::where('proj_id', $proj['id'])
            ->sum('amount');
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
            $this->addNotifHead($req, $proj);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function addNotifHead($req, $proj)
    {
        // notify finance of edited project
        $role = config('constants.role_head');
        $user_ids = UserRoles::where('role_id', $role)->lists('user_id');

        $data = [
            'title' => 'Project Approval',
            'text' => trans('notifications.project_approval', ['name' => $proj->name]),
            'proj_id' => $proj->id,
            'user_ids' => $user_ids
        ];

        $this->saveNotif($data);
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
        // Log::info(json_encode(DB::getQueryLog()));
        $data['msg'] = $msg;
        $data['status'] = $status;
        return Response::json($data);
    }

    public function budgetReport(Request $request)
    {
        $status = FALSE;
        $msg = '';
        try {
            $startDate = $request['from'];
            $endDate = $request['to'];
            $completed = config('constants.proj_status_completed');
            $project = new App\Project();
            // get all projects completed
            $completed = $project->with('budget_request', 'expenses')
            ->whereBetween(DB::raw('YEAR(start_date)'), [$startDate, $endDate])
            ->where('proj_status_id', $completed)->get();
            $withRequest = $leftOvers = $withoutRequest = [];

            foreach($completed AS $key => &$val) {
                $val['total_budget'] = number_format($val['total_budget'],2,'.',',');
                $val['totalBudgetRequested'] = number_format($val->budget_request->sum('amount'),2,'.',',');
                $val['totalExpense'] = number_format($val->expenses->sum('amount'),2,'.',',');
                $val['remaining'] = number_format($val['totalBudgetRequested'] + $val['total_budget'] - $val['totalExpense'],2,'.',',');

                // projects with budget request
                if($val['totalBudgetRequested'])
                    array_push($withRequest, $val);

                // projects with leftover funds
                if($val['remaining'])
                    array_push($leftOvers, $val);

                // projects without budget request
                if(EMPTY($val['totalBudgetRequested']) && EMPTY($val['remaining']))
                    array_push($withoutRequest, $val);
            }
            $html = view('reports/budget', compact('withoutRequest', 'withRequest', 'leftOvers'));

            $html = utf8_encode($html);
            $pdf = new \mPDF();
            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);
            $pdf->Output();
            exit();
        } catch(\Exception $e) {
            $msg = $e->getMessage();
        }

        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function statusReport($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
            ->leftJoin('resource_persons AS rp', 'rp.id', '=', 'projects.resource_person_id')
            ->leftJoin('personal_info AS rpi', 'rpi.id','=', 'rp.personal_info_id')
            ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
            ->leftJoin('user_info', 'user_info.user_id','=','users.id')
            ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
            ->where('projects.id', $id)->first(['projects.*','programs.name AS program', 'total_budget',
                'rpi.first_name', 'rpi.middle_name', 'rpi.last_name',
                DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')], 'remarks');

            $data['activities'] = App\ProjectActivities::where('proj_id', $id)
                ->leftJoin('activities', 'activities.id', '=', 'proj_activities.activity_id')
                ->get(['name', 'id', 'status_id']);

            foreach($data['activities'] AS $key => $val) {
                // logger('activity');
                // logger(json_encode($val));
                $data['activities'][$key]['status'] = config('constants.activity_status.'.$val['status_id']);
                $data['activities'][$key]['tasks'] = App\Task::where('activity_id', $val['id'])->get();
            }

            $data['expenses'] =  App\ProjectExpense::where('proj_id', $id)->get();

            // compute used by activities
            foreach($data['expenses'] AS &$val) {
                $val->items = App\ActivityItemExpense::where('project_expense_id', $val['id'])->get();
                // $val->activity = App\Activities::find($val->items[0]['activity_id']);
            }

            $data['total_expense'] = App\ProjectExpense::where('proj_id', $id)
            ->sum('amount');

            $data['total_budget_request'] = App\ProjectBudgetRequest::where('proj_id', $id)
    			// 2 = approve
    			->where('status_id', 2)->sum('amount');

            $data['total_budget'] = $data['proj']->total_budget + $data['total_budget_request'];

            $data['proj_id'] = $id;

            $start_date =  Carbon::createFromFormat('Y-m-d',$data['proj']->start_date);
            $end_date =  Carbon::createFromFormat('Y-m-d', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);
            $data['duration'] = $this->_convertToYearMonthDays($days);
            // $data['proj'] = $data['proj']->get();
            // logger('projects');
            // logger($data['proj']);
            // $data['chart'] = $this->createChart($id);
            $html = view('reports/project-status', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();

            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);

            // $user = auth()->user()->infos[0];
            // $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            // $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
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

    public function completionReport($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
            ->leftJoin('resource_persons AS rp', 'rp.id', '=', 'projects.resource_person_id')
            ->leftJoin('personal_info AS rpi', 'rpi.id','=', 'rp.personal_info_id')
            ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
            ->leftJoin('user_info', 'user_info.user_id','=','users.id')
            ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
            ->where('projects.id', $id)->first(['projects.*','programs.name AS program', 'total_budget',
                'rpi.first_name', 'rpi.middle_name', 'rpi.last_name',
                DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')], 'remarks');

            $data['activities'] = App\ProjectActivities::where('proj_id', $id)
                ->leftJoin('activities', 'activities.id', '=', 'proj_activities.activity_id')
                ->get(['name', 'id', 'status_id']);

            foreach($data['activities'] AS $key => $val) {
                // logger('activity');
                // logger(json_encode($val));
                $data['activities'][$key]['status'] = config('constants.activity_status.'.$val['status_id']);
                $data['activities'][$key]['tasks'] = App\Task::where('activity_id', $val['id'])->get();
            }
            // logger(json_encode($data['activities'],JSON_PRETTY_PRINT));

            $data['expenses'] =  App\ProjectExpense::where('proj_id', $id)->get();

            // compute used by activities
            foreach($data['expenses'] AS &$val) {
                $val->items = App\ActivityItemExpense::where('project_expense_id', $val['id'])->get();
                // $val->activity = App\Activities::find($val->items[0]['activity_id']);
            }

            $data['total_expense'] = App\ProjectExpense::where('proj_id', $id)
            ->sum('amount');

            $data['total_budget_request'] = App\ProjectBudgetRequest::where('proj_id', $id)
    			// 2 = approve
    			->where('status_id', 2)->sum('amount');

            $data['total_budget'] = $data['proj']->total_budget + $data['total_budget_request'];

            $data['proj_id'] = $id;

            $start_date =  Carbon::createFromFormat('Y-m-d',$data['proj']->start_date);
            $end_date =  Carbon::createFromFormat('Y-m-d', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);
            $data['duration'] = $this->_convertToYearMonthDays($days);
            // $data['proj'] = $data['proj']->get();
            // logger('projects');
            // logger($data['proj']);
            // $data['chart'] = $this->createChart($id);
            $html = view('reports/project-completion', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();

            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);

            // $user = auth()->user()->infos[0];
            // $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            // $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
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

    // project charter report
    public function progressReport($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::leftJoin('programs', 'programs.id','=','projects.program_id')
            ->leftJoin('resource_persons AS rp', 'rp.id', '=', 'projects.resource_person_id')
            ->leftJoin('personal_info AS rpi', 'rpi.id','=', 'rp.personal_info_id')
            ->leftJoin('users', 'users.id', '=', 'projects.champion_id')
            ->leftJoin('user_info', 'user_info.user_id','=','users.id')
            ->leftJoin('personal_info AS champ', 'champ.id', '=','user_info.personal_info_id')
            ->where('projects.id', $id)->first(['projects.*','programs.name AS program', 'total_budget',
                'rpi.first_name', 'rpi.middle_name', 'rpi.last_name',
                DB::raw('CONCAT(champ.first_name, " ", champ.middle_name, " ", champ.last_name) AS champ_name')], 'remarks');

            $data['activities'] = App\ProjectActivities::where('proj_id', $id)
                ->leftJoin('activities', 'activities.id', '=', 'proj_activities.activity_id')
                ->get(['name', 'id', 'status_id']);

            foreach($data['activities'] AS $key => $val) {
                // logger('activity');
                // logger(json_encode($val));
                $data['activities'][$key]['status'] = config('constants.activity_status.'.$val['status_id']);
                $data['activities'][$key]['tasks'] = App\Task::where('activity_id', $val['id'])->get();
            }
            // logger(json_encode($data['activities'],JSON_PRETTY_PRINT));

            $data['expenses'] =  App\ProjectExpense::where('proj_id', $id)->get();
            // logger(EMPTY($data['expenses']));
            $data['total_expense'] = App\ProjectExpense::where('proj_id', $id)
            ->sum('amount');

            $data['total_budget_request'] = App\ProjectBudgetRequest::where('proj_id', $id)
    			// 2 = approve
    			->where('status_id', 2)->sum('amount');

            $data['total_budget'] = $data['proj']->total_budget + $data['total_budget_request'];

            $data['proj_id'] = $id;

            $start_date =  Carbon::createFromFormat('Y-m-d',$data['proj']->start_date);
            $end_date =  Carbon::createFromFormat('Y-m-d', $data['proj']->end_date);
            $days = $end_date->diffInDays($start_date);
            $data['duration'] = $this->_convertToYearMonthDays($days);
            // $data['proj'] = $data['proj']->get();
            // logger('projects');
            // logger($data['proj']);
            // $data['chart'] = $this->createChart($id);
            $html = view('reports/project', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();
            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);

            // $user = auth()->user()->infos[0];
            // $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            // $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function summaryReport(Request $request)
    {
        $period = $request->all();
        $status = FALSE;
        $msg = '';
        try
        {
            // $projects = Project::get();
            $completed = App\Project::where('proj_status_id', config('constants.proj_status_completed'))
                ->whereBetween(DB::raw('YEAR(start_date)'), [$period['from'], $period['to']])->get();
            $onTime = App\Project::where('proj_status_id', config('constants.proj_status_completed'))
                ->where('end_date', '>=', DB::raw('actual_end'))
                ->whereBetween(DB::raw('YEAR(start_date)'), [$period['from'], $period['to']])->get();
                logger($onTime);
            $delayed = App\Project::where(function($query) use ($period) {
                //delayed projects
                $query->where('proj_status_id', '!=', config('constants.proj_status_completed'))
                    ->where('end_date', '<', date('Y-m-d H:i:s'))
                    ->whereBetween(DB::raw('YEAR(start_date)'), [$period['from'], $period['to']]);
            })
            // completed but delayed
                ->orWhere(function($query) use ($period) {
                $query->where('proj_status_id', config('constants.proj_status_completed'))
                    ->where('end_date', '<', DB::raw('actual_end'))
                    ->whereBetween(DB::raw('YEAR(start_date)'), [$period['from'], $period['to']]);
            })->get();
            $html = view('reports/project-summary', compact('delayed', 'onTime', 'completed'));
            $html = utf8_encode($html);
            $pdf = new \mPDF();

            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);

            $user = auth()->user()->infos[0];
            $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function expenseReport($id)
    {
        $status = FALSE;
        $msg = '';
        try
        {
            $data['proj'] = App\Projects::find($id);

            $data['categories'] = App\ProjectExpense::where('proj_id',$data['proj']->id)
                ->get();

            foreach($data['categories'] as &$val) {
                $val->activities = App\ActivityItemExpense::where('project_expense_id', $val->id)
                    ->leftJoin('activities', 'activities.id', '=', 'activity_item_expenses.activity_id')
                    ->groupBy('activity_id')
                    ->get([DB::raw('SUM(price * activity_item_expenses.quantity) AS expense'), 'name']);
            }
            // $select = [
            //     'activities.name',
            //     'activity_item_expenses.quantity',
            //     'activity_item_expenses.price',
            //     'project_expenses.category as category'
            // ];
            // $activity = App\Activities::leftJoin('proj_activities', 'proj_activities.activity_id', '=', 'activities.id')
            //             ->leftJoin('activity_item_expenses', 'activities.id', '=', 'activity_item_expenses.activity_id')
            //             ->leftJoin('project_expenses', 'project_expenses.proj_id', '=', 'proj_activities.proj_id')
            //             ->where('proj_activities.proj_id', $id)->orderBy('activities.id')->get($select);
            // logger($activity);
            $html = view('reports/project-expense', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();

            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);
            $user = auth()->user()->infos[0];
            $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }

    public function createChart($id)
    {
        // Log::info('create chart');
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

    public function getActivityChart()
    {
        $activities = App\Activities::get(['status_id']);
        $status = App\ActivityStatus::get(['id', 'name']);

        $data = [];
        $colors = [];
        $labels = [];
        $total = $activities->count();
        foreach($status as $key => $val) {
            $numOfProj = $activities->where('status_id', $val->id)->count();
            $value = $numOfProj/$total * 100;
            $color = $this->getColorsUnique($key);
            $data[] = number_format($value, 2);
            $colors[] = $color;
            $labels[] = $val->name;
        }

        $params = [
            'type' => 'pie',
            'data' => [
                'datasets'=> [[
                    'data' => $data,
                    'backgroundColor' => $colors
                ]],
                'labels' => $labels,
            ],
            'options' => [
                'responsive' => true
            ]
        ];
        return $params;
    }

    public function getProjectChart()
    {
        // get all programs
        $project = App\Projects::get(['program_id']);
        $programs = App\Program::get(['id','name']);

        $data = [];
        $colors = [];
        $labels = [];
        $total = $project->count();
        foreach($programs as $key => $val) {
            $numOfProj = $project->where('program_id', $val->id)->count();
            $value = $numOfProj/$total * 100;
            $color = $this->getColorsUnique($key);
            $data[] = number_format($value, 2);
            $colors[] = $color;
            $labels[] = $val->name;
        }

        $params = [
            'type' => 'pie',
            'data' => [
                'datasets'=> [[
                    'data' => $data,
                    'backgroundColor' => $colors
                ]],
                'labels' => $labels,
            ],
            'options' => [
                'responsive' => true
            ]
        ];
        return $params;
    }

    public function getProjectStatusChart()
    {
        $project = App\Project::get(['proj_status_id']);
        $status = App\ProjectStatus::get(['id', 'name']);

        $data = [];
        $colors = [];
        $labels = [];
        $total = $project->count();
        foreach($status as $key => $val) {
            $numOfProj = $project->where('proj_status_id', $val->id)->count();
            $value = $numOfProj/$total * 100;
            $color = $this->getColorsUnique($key);
            $data[] = number_format($value, 2);
            $colors[] = $color;
            $labels[] = $val->name;
        }

        $params = [
            'type' => 'pie',
            'data' => [
                'datasets'=> [[
                    'data' => $data,
                    'backgroundColor' => $colors
                ]],
                'labels' => $labels,
            ],
            'options' => [
                'responsive' => true
            ]
        ];
        return $params;
    }

    public function getColorsUnique($key) {
        $colors = [
            // BLUE
            '#0074D9',
            // AQUA
            '#7FDBFF',
            // TEAL
            '#39CCCC',
            // OLIVE
            '#3D9970',
            // GREEN
            '#2ECC40',
            // LIME
            '#01FF70',
            // YELLOW
            '#FFDC00',
            // ORANGE
            '#FF851B',
            // RED
            '#FF4136',
            // MAROON
            '#85144b',
            // FUCHSIA
            '#F012BE'
        ];

        return $colors[$key];
    }

    public function periodModal() {
      return view('modals.period-modal');
    }

    public function volunteersReport()
    {
        $id = 1;
        $status = FALSE;
        $msg = '';
        try
        {
            // $projIds = App\Projects::whereIn('proj_status_id', [1, 4, 5])->pluck('id');
            $volunteers = App\User::with(['infos', 'tasks.activity.projects.program'])
                 ->join('user_roles', function ($join) {
                       $join->on('users.id', '=', 'user_roles.user_id')
                       ->where('user_roles.role_id', '=', 6);
                   })
                 ->get();
            // logger(json_encode($volunteers, JSON_PRETTY_PRINT));

            $data['volunteers'] = $volunteers;

            $html = view('reports/volunteers-status', $data);
            $html = utf8_encode($html);
            $pdf = new \mPDF();

            $pdf->setFooter('{PAGENO} / {nb}');
            $pdf->writeHTML($html);
            $user = auth()->user()->infos[0];
            // $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
            // $pdf->SetFooter('Generated By: ' . ucwords($fullName) . '| Dated: ' . date('F d, Y'));
            $pdf->Output();
            exit();
        }
        catch(\Exception $e)
        {
            logger($e);
            $msg = $e->getMessage();
        }
        $data['status'] = $status;
        $data['msg'] = $msg;

        return Response::json($data);
    }
}
