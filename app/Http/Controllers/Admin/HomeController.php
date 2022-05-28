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
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;


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
    public function profileinfo(){
        $moreinfo = userinfo::where('user_id',Auth::guard('web')->user()->id)->count();
        $employees = User::with('moreinfo')->find(Auth::guard('web')->user()->id);
        // dd($employees->toArray());
        return view('employees.profile.profile',compact('employees','moreinfo'));
    }
    public function profilemoreinfo(){
        $moreinfo = userinfo::where('user_id',Auth::guard('web')->user()->id)->count();
        if($moreinfo>0){
            return redirect()->back();
        }else{
            return view('employees.profile.moreinfo');
        }
        }
    public function empmoreinfo(Request $request){
        // dd($request->toArray());
        $rules = [
            'nationality' => ['required', 'string',],
            'maritalstatus' => ['required', 'string'],
            'children' => ['required', 'string',],
            'bankname' => ['required', 'string',],
            'bankAc' => ['required', 'integer',],
            'ifsc' => ['required', 'string',],
            'pan' => ['required', 'string',],
        ];
        $request->validate($rules);
        $data = new userinfo();
        $data->user_id = $request->user_id;
        $data->nationality =$request->nationality;
        $data->maritalStatus =$request->maritalstatus;
        $data->noOfChildren =$request->children;
        $data->bankname =$request->bankname;
        $data->bankAc =$request->bankAc;
        $data->ifsc =$request->ifsc;
        $data->pan =$request->pan;
        $data->status =1;
        $data->save();
        return redirect()->route('employees.add.moreinfo');
    }
}
