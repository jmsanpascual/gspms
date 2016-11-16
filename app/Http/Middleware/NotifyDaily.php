<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use App\Project;
use App\Traits\Notify;
use App\UserRoles;
use Exception;
use DB;

class NotifyDaily
{
    use Notify;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // logger('test ' . Cache::get('notify'));
        // Cache::forget('notify');
        if(Cache::get('notify') != date('Y-m-d')) {
            try {
                DB::beginTransaction();
                $this->_notifyProjects();
                Cache::forever('notify', date('Y-m-d'));
                DB::commit();
            } catch(Exception $e) {
                DB::rollback();
                logger($e);
            }
        }

        return $next($request);
    }

    private function _notifyProjects() {
        // not yet completed projects
        $proj_query = Project::where('proj_status_id', config('constants.proj_status_completed'));

        $this->_notDoneOnDue($proj_query);
        $this->_almostDue($proj_query);
    }

    private function _notDoneOnDue($proj_query) {
        // check first the due dates of project
        $date = date('Y-m-d');

        // check if already notified and already on due
        $proj_query = $proj_query->where('end_date', '<=', $date)->where('notifyDate', '!=', $date);
        $proj = $proj_query->get();

        // if no project on due exit;
        if(EMPTY($proj)) return;
        // need to notify all life directors and champion responsible in project
        // get the user id with role of life
        $ids = UserRoles::where('role_id', config('constants.role_life'))->lists('user_id');

        foreach($proj as $key => $val) {
            $user_ids = $ids;
            //get the id of champion per project
            $user_ids[] = $val->champion_id;
            $data = [
                'title' => 'Project past due.',
                'text' =>  trans('notifications.proj_due', ['name'=> $val['name']]),
                'proj_id' => $val['id'],
                'user_ids' => $ids
            ];

            $this->saveNotif($data);
        }

        // update the proj notifDate to inform that project is already notified to users
        $proj_query->update([
            'notifyDate' => $date
        ]);
    }

    private function _almostDue($proj_query) {
        // project is not done and less than 80% finished with 20% time left notify LIFE AND CHAMPION responsible
        // $date = date('Y-m-d');
        // filter end dates must not yet due
        // $proj = $proj_query->where('end_date', '>', $date)
        //     ->get();
        // then compute if already 20%
        // foreach() {

        // }
    }
}
