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
    public function data(Request $request)
    {
        $data = Log::info('json: '.json_encode($request->all()));
        return response()->json($data);
    }

    public function newdata(Request $request)
    {
        $data = Log::info('json: '.json_encode($request->all()));
        return response()->json($data);
    }

    public function dashboard(){
        $emp_count = User::count();
        $project_count = Projects::count();
        return view('admin.dashboard', compact('emp_count', 'project_count'));
    }

}
