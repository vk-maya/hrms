<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projects;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyTasks;

class HomeController extends Controller
{
    public function dashboard()
    {
        $emp_count = User::count();
        $project_count = Projects::count();
        return view('admin.dashboard', compact('emp_count', 'project_count'));
    }
    public function empdashboard()
    {
        $data = DailyTasks::where('user_id', Auth::guard('web')->user()->id)->latest()->take(1)->get();
        return view('employees.dashboard',compact('data'));
        // dd($data);
    }
}
