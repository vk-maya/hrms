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
        // $attendance= Attendance::where('user_id',Auth::guard('web')->user()->machineID)->get();
        // $leavesOfAttendance = Attendance::where('user_id', $id)->where('attendance',"A")->where('status',0)->where(function ($query) use ($firstDayofPreviousMonth, $LastDayOfPreviousmonth) {
        //     $query->whereBetween('date', [$firstDayofPreviousMonth, $LastDayOfPreviousmonth]);
            $first_date = date('Y-m-d',strtotime('first day of this month'));
            $last_date = date('Y-m-d',strtotime('last day of this month'));
        // })->count();
        $attendance= Attendance::where('user_id',Auth::guard('web')->user()->id)->where(function($query)use($first_date,$last_date){
            $query->whereBetween('date',[$first_date,$last_date]);
        })->orderBy('created_at', 'DESC')->get();

            // dd($attendance);
        return view('employees.leave.attendance',compact('attendance'));
    }
}
