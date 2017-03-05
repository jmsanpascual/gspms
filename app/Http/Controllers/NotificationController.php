<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Projects;
use App\ProjectStatus;
use App\UserNotification;

class NotificationController extends Controller
{

    public function index()
    {

        $id = auth()->id();
        $select = ['notifications.*', 'un.read_flag', 'un.id as userNotifId'];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    ->where('un.user_id', $id)->where('un.read_flag', 0);
                    // ->join('personal_info as pi', 'pi.id', '=', 'un.user_id')
                    // ->join('projects as p', 'p.id', '=', 'notifications.project_id')
        $data['count'] = $notif->count();

        $data['notif'] = $notif->orderBy('created_at', 'desc')->get($select)->take(6);
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

    public function getAllNotif()
    {
        $id = auth()->id();
        $select = ['notifications.*', 'un.read_flag', 'un.id as userNotifId'];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    ->where('un.user_id', $id)->orderBy('created_at', 'desc')->get($select);
        return $notif;
    }

    public function lists()
    {
        return view('notifications');
    }

    public function dashboard()
    {
        return view('dashboard');
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
