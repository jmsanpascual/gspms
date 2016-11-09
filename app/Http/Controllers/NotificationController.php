<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index() {
        $id = auth()->id();
        $select = ['notifications.*'];
        $notif = \App\Notification::join('user_notifications as un', 'un.notification_id', '=', 'notifications.id')
                    // ->join('personal_info as pi', 'pi.id', '=', 'un.user_id')
                    // ->join('projects as p', 'p.id', '=', 'notifications.project_id')
                    ->where('un.user_id', $id)->get($select);
        return $notif;
    }
}
