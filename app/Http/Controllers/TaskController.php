<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;
use Response;
use Hash;
use Lang;
use Log;
use DB;

class TaskController extends Controller
{
    protected $roleId = 6;
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index()
    {
        $roleId = $this->roleId;

        try {
            $tasks = Task::with('activity.projects')->where('user_id', $this->user->id)->get();

            return Response::json($tasks);
        } catch (Exception $e) {
            return Response::json([['error' => $e->getMessage()]]);
        }
    }

    public function create()
    {
        return view('modals/task');
    }

    public function update(Request $request)
    {
        try {
            $task = $request->get('task');
            $taskId = $task['id'];
            unset($task['activity']);

            Task::where('id', $taskId)->update($task);

            return Response::json(['result' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()]);
        }
    }
}
