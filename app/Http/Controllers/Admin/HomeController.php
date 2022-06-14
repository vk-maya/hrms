<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projects;
use App\Models\userinfo;
use App\Models\DailyTasks;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;


class HomeController extends Controller
{

    public function dashboard(){
        $emp_count = User::count();
        $project_count = Projects::count();
        // $department = Designation::with('department')->get();
        $users = User::with('userDesignation','attendance')->get();
        $absent = User::where('status','1')->whereHas('attendance',function($query){
            $query->where('attendance','A')->where('date',now()->format('Y-m-d'));
        })->count();
        // dd($absent );
        return view('admin.dashboard', compact('emp_count', 'project_count','users','absent'));
    }
 

}