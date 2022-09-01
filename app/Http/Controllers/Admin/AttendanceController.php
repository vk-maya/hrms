<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\monthleave;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //
    public function attendance($date = ''){
        if(empty($date)){
            $date = now()->toDateString();
        }
        $attinfo= "";
        // $attendance = Attendance::with('userinfo')->get();
        $first_date = date('Y-m-d',strtotime('first day of this month'));
        $last_date = date('Y-m-d',strtotime('last day of this month'));
        $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
            $query->whereBetween('date', [$first_date,$last_date]);
        }])->where('status', 1)->orderBy('users.first_name')->get();
        $month = (new DateTime($date))->format('t');
        return view('admin.attendance.attendance',compact('attendance','month'));
    }
    public function attendanceEmployee(){
        if(empty($date)){
            $date = now()->toDateString();
        }
        $attinfo= "";
        $first_date = date('Y-m-d',strtotime('first day of this month'));
        $last_date = date('Y-m-d',strtotime('last day of this month'));
        $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
            $query->whereBetween('date', [$first_date,$last_date]);
        },'monthleave'=> function($query)use($first_date,$last_date){
            $query->where('from', [$first_date,])->where('to',$last_date);
        }])->where('status', 1)->orderBy('users.first_name')->get();
        $month = (new DateTime($date))->format('t');
        return view('admin.attendance.employee',compact('attendance','month'));
    }
    public function attinfo($id){
        $attendinfo = Attendance::find($id);
    
        return response()->json(['attend' => $attendinfo]);

    }
    public function attendanceMonthRecord($id,$date){
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $monthrecord= Attendance::with('userinfoatt')->where('user_id',$id)->where('month',$month)->where('year',$year)->get();   
        return view('admin.attendance.employeerecord',compact('monthrecord'));
    }
        public function recordReport(Request $request){
            $attendance = Attendance::find($request->id);
            $attendance->mark=$request->status;
            $attendance->save();
        return redirect()->back();
        }
    }
