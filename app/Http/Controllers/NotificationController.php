<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Projects;
use App\ProjectStatus;
use App\UserNotification;
use Session;

class NotificationController extends Controller
{

    public function index()
    {

        $id = auth()->id();
        $select = [
            'notifications.title',
            'notifications.text',
            'notifications.created_at as notif_created',
            'un.read_flag',
            'un.id as userNotifId',
            'projects.*'
        ];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    ->leftJoin('projects', 'projects.id', '=', 'notifications.project_id')
                    ->where('un.user_id', $id)->where('un.read_flag', 0);
                    // ->join('personal_info as pi', 'pi.id', '=', 'un.user_id')
                    // ->join('projects as p', 'p.id', '=', 'notifications.project_id')
        $data['count'] = $notif->count();

        $data['notif'] = $notif->orderBy('notifications.created_at', 'desc')->get($select)->take(6);
        return $data;
    }

    public function read($id)
    {
        $msg = '';
        $status = FALSE;
        try {
            $notif = UserNotification::find($id);
            $notif->read_flag = 1;
            $notif->save();
            $status = TRUE;
        } catch(Exception $e) {
            $msg = $e->getMessage();
        }
        $data['status']= $status;
        $data['msg'] = $msg;

        return $data;
    }

    public function projects($id, $userNotifId)
    {
        $status = FALSE;
        $message = '';
        try{
            $proj = (new Projects)->getTable();
            $stat = (new ProjectStatus)->getTable();
            $token = csrf_token();
            $data['proj'] = Projects::JoinStatus();

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

            $data['proj'] = $data['proj']->where($proj.'.id', $id)->first($select);
            $temp = explode('(#$;)', $data['proj']->objective);
            $data['proj']->objective = $temp;

            // update notification read flag
            $notif = UserNotification::find($userNotifId);
            $notif->read_flag = 1;
            $notif->save();

            $status = true;
        } catch(\Exception $e) {
            logger($e);
            $message = $e->getError();
        }

        $data['status'] = $status;
        $data['message'] = $message;

        return view('modals.notif-proj', $data);
    }

    public function todo()
    {
        $status = FALSE;
        $message = '';
        try {
            $todo = UserNotification::where('user_id', auth()->id())
                ->leftJoin('notifications', 'notifications.id', '=', 'user_notifications.notification_id')
                ->leftJoin('projects', 'projects.id', '=', 'notifications.project_id');

            $select = ['projects.*'];

            if(Session::get('role') == config('constants.role_life')) {
                $todo = $todo->whereIn('proj_status_id', [6]);
            } else if(Session::get('role') == config('constants.role_finance')) {
                $todo = $todo->whereIn('proj_status_id', [2]);
            } else if(Session::get('role') == config('constants.role_champion') ||
                Session::get('role') == config('constants.role_exec')) {
                $todo = $todo->whereIn('proj_status_id', [4,5]);
            }

            $todo = $todo->get($select);
            $status = TRUE;
        } catch(Exception $e) {
            $message = $e->getMessage();
        }
        $data['status'] = $status;
        $data['message'] = $message;
        $data['todo'] = $todo;

        foreach($data['todo'] as $key => $value) {
            $temp = explode('(#$;)', $value->objective);
            $data['todo'][$key]->objective = $temp;
         }
        return $data;
    }

    public function getAllNotif()
    {
        $id = auth()->id();
        $select = [
            'notifications.title',
            'notifications.text',
            'notifications.created_at as notif_created',
            'un.read_flag',
            'un.id as userNotifId',
            'projects.*'
        ];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    ->leftJoin('projects', 'projects.id', '=', 'notifications.project_id')
                    ->where('un.user_id', $id)->orderBy('created_at', 'desc')->get($select);
        return $notif;
    }

    public function lists()
    {
        return view('notifications');
    }

    public function dashboard()
    {
        // $chart =
        //  $this->createChart();
        return view('dashboard');
    }

    public function createChart()
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
        return $chart->render('generated/test.png');
    }

    public function todos()
    {
        // check all notification that is not yet read
        $id = auth()->id();
        $select = ['notifications.*', 'un.id as userNotifId'];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    ->where('un.user_id', $id)->where('un.read_flag', 0)->orderBy('created_at', 'desc')->get($select);

        return $notif;
    }

    public function delayedProjects()
    {
        //  refer to project controller
        //  index function
    }

    public function upcoming()
    {

    }
}
