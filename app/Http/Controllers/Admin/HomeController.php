<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projects;
use App\Models\DailyTasks;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    public function dashboard()
    {
        $emp_count = User::count();
        $project_count = Projects::count();
        return view('admin.dashboard', compact('emp_count', 'project_count'));
    }
    // ---------------employees function-----------------------
    public function empdashboard()
    {
        $data = DailyTasks::where('user_id', Auth::guard('web')->user()->id)->latest()->take(1)->get();
        return view('employees.dashboard',compact('data'));
        // dd($data);
    }
    public function profile(){
        return view('employees.profile.profile-password');
    } 
}
