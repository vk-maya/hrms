<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Models\Task as ModelsTask;
use App\Http\Controllers\Controller;
use App\Models\TaskFollowers;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;


class Task extends Controller
{
    public function task(){
        // $data = TaskFollowers::with('taskreport')->get();
        $task = TaskFollowers::with(['taskDetails.assigned','projectDetails','taskreport'])->where('team_id', Auth::guard('web')->user()->id)->get();
        // dd($task->toArray());
        return view('employees.task', compact('task'));
    }
    public function taskstatus(Request $request){
        $data = new TaskStatus();
        $data->task_id= $request->task_id;
        $data->report= $request->report;
        $data->status = ($request->status == 1) ? 1 : 0;
        $data->save();
        return redirect()->back();

    }
    public function taskcomplete($id){
        $data = ModelsTask::find($id);
        $data->status = 0;
        $data->update();
        return response()->json(['success'=>$data->status]);
    }
}
