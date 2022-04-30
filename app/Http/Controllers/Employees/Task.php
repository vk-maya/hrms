<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Models\Task as ModelsTask;
use App\Http\Controllers\Controller;
use App\Models\TaskFollowers;
use Illuminate\Support\Facades\Auth;


class Task extends Controller
{
    public function task(){
        $task =TaskFollowers::with(['taskDetail','projectDetail'])->where('team_id', Auth::guard('web')->user()->id)->get();
        // dd($task->toArray());
        return view('employees.task', compact('task'));
    }
}
