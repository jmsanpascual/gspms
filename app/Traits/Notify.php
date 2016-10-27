<?php namespace App\Traits;

use App\Notification;
use App\UserRoles;
use App\UserNotification;
use Exception;

trait Notify {
    public function saveNotif($params) {
        try {
            $id = Notification::insertGetId([
                'title' => $params['title'],
                'text' => $params['text'],
                'project_id' => $params['proj_id']
            ]);

            // if project is done notify all except champion
            //so we need to look for users with role not champion

            $user_ids = $params['user_ids'] ?: UserRoles::where('role_id', '!=', $params['role'])->lists('user_id');

            $date = date('Y-m-d H:i:s');
            // format data to be inserted
            $data = [];
            foreach($user_ids as $key => $val) {
                $data[$key]['user_id'] = $val;
                $data[$key]['notification_id'] = $id;
                $data[$key]['read_flag'] = 0;
                $data[$key]['created_at'] = $date;
            }

            UserNotification::insert($data);
        } catch(Exception $e) {
            throw $e;
        }
    }
}
