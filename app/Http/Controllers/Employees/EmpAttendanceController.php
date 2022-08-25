<?php

namespace App\Http\Controllers\Employees;

use App\Models\Attendance;
use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Leave\settingleave;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmpAttendanceController extends Controller
{
    //
    public function get(){      
            $first_date = date('Y-m-d',strtotime('first day of this month'));
            $last_date = date('Y-m-d',strtotime('last day of this month'));
        $attendance= Attendance::with('wfh','leavestatus')->where('user_id',Auth::guard('web')->user()->id)->where(function($query)use($first_date,$last_date){
            $query->whereBetween('date',[$first_date,$last_date]);
        })->orderBy('created_at', 'DESC')->get();
        $leaveType= settingleave::where('status',1)->get();
        // dd($attendance->toArray());
        return view('employees.leave.attendance',compact('attendance','leaveType'));
    }
}
