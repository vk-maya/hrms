<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Admin\UserSlip;
use App\Models\Admin\CompanyProfile;
use Illuminate\Support\Facades\Auth;

class UserslipController extends Controller
{
    public function userSlip(){
        $salipList= UserSlip::where('user_id',Auth::guard('web')->user()->id)->orderBy('id','desc')->get();
        return view('employees.payroll.salary-slip',compact('salipList'));
    }
    public function slipview($id){
        $company = CompanyProfile::where('status', 1)->first();
        $slip = UserSlip::find($id);
        $user=User::with('designation')->find(Auth::guard('web')->user()->id);
        // dd($user->toArray());
        return response()->json(compact('company', 'slip','user'));
    }
}
