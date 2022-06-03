<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpAttendanceController extends Controller
{
    //
    public function get(){
        $attendance= Attendance::where('user_id',Auth::guard('web')->user()->machineID)->get();
        return view('employees.leave.attendance',compact('attendance'));
    }
}
