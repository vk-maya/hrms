<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Projects;
use App\Models\User;

class HomeController extends Controller
{
    public function dashboard()
    {
        $emp_count = User::count();
        $project_count = Projects::count();
        return view('admin.dashboard', compact('emp_count', 'project_count'));
    }
}
