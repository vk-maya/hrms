<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Projects;
use App\Models\userinfo;
use App\Models\Countries;
use App\Models\Attendance;
use App\Models\DailyTasks;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\CompanyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
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
        ///........................settings......................////

    public function settings()
    {
        // $setting = CompanyProfile::all();
        $data = Countries::all();
        return view('admin.payroll.setting',compact('data'));
    }
    public function setting_store(Request $request){
        // dd($request->toArray());
        $company= new CompanyProfile();
        $company->c_address=$request->c_address;
        $company->country_id=$request->country;
        $company->state_id=$request->state;
        $company->city_id=$request->city;
        $company->name=$request->name;
        $company->co_name=$request->co_name;
        $company->email=$request->email;
        $company->phone=$request->number;
        $company->other_phone=$request->other_number;
        $company->p_address=$request->p_address;
        $company->postl=$request->postal;
        $company->web=$request->web;
        $company->status=1;
        $company->save();
        return redirect()->back();
    }
 

}