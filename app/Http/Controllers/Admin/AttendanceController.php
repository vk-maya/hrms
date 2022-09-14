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
            
        $first_date = date('Y-m-d',strtotime('first day of this month'));
        $last_date = date('Y-m-d',strtotime('last day of this month'));
        $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
            $query->whereBetween('date', [$first_date,$last_date]);
        }])->where('status', 1)->orderBy('users.first_name')->get();
        $month = (new DateTime($date))->format('t');
        $monthYears = date('Y-m');

        return view('admin.attendance.attendance',compact('attendance','month','monthYears'));
    }
    //filter search function
    public function attendanceSearch(Request $request){
      
        $first_date = Carbon::createFromDate($request->year,$request->month)->startOfMonth()->toDateString();
        $last_date = Carbon::createFromDate($request->year,$request->month)->endOfMonth()->toDateString();
        if(empty($date)){
            $date = $last_date;
        }   
        if (!empty($request->user_id)){
            $attendance = User::where('id',$request->user_id)->with(['attendence' => function($query)use($first_date,$last_date){
                $query->whereBetween('date', [$first_date,$last_date]);
            }])->where('status', 1)->orderBy('users.first_name')->get();

        }else{
            $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
                $query->whereBetween('date', [$first_date,$last_date]);
            }])->where('status', 1)->orderBy('users.first_name')->get();
        }
        $month = (new DateTime($date))->format('t');
        $monthYears = date("Y-m",strtotime($first_date));
        return view('admin.attendance.attendance',compact('attendance','month','monthYears'));
    
    }
    public function attendanceEmployee(Request $request){
        $attendance = User::query();
            $attendance->where('id',$request->user_id);
        $method = 'monthleave';
            $first_date = Carbon::createFromDate()->startOfMonth()->toDateString();
            $last_date = Carbon::createFromDate()->endOfMonth()->toDateString();
        $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
            $query->whereBetween('date', [$first_date,$last_date]);
        },  $method => function($query)use($first_date,$last_date){
            $query->where('from', $first_date)->where('to',$last_date);
        }])->where('status', 1)->orderBy('users.first_name')->get();    
        $allemployees= User::where('status',1)->orderBy('first_name')->get(['first_name','id']);
        return view('admin.attendance.employee',compact('attendance','allemployees','method'));
    }
    //attendance search function
    public function attendanceEmployeeSearch(Request $request){
        $first_date = Carbon::createFromDate($request->year,$request->month)->startOfMonth()->toDateString();
        $last_date = Carbon::createFromDate($request->year,$request->month)->endOfMonth()->toDateString();
        $method = 'monthleavelist';
        if (!empty($request->user_id)){
            $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
                $query->whereBetween('date', [$first_date,$last_date]);
            }, $method => function($query)use($first_date,$last_date){
                $query->where('from', $first_date)->where('to',$last_date);
            }])->orderBy('users.first_name')->where('id',$request->user_id)->get();
        }else{
            $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
                $query->whereBetween('date', [$first_date,$last_date]);
            },$method => function($query)use($first_date,$last_date){
                $query->where('from', $first_date)->where('to',$last_date);
            }])->orderBy('users.first_name')->get();
        }
        $allemployees= User::orderBy('first_name')->get(['first_name','id']);
        return view('admin.attendance.employee',compact('attendance','allemployees','method'));

    }
    public function attinfo($id){
        $attendinfo = Attendance::find($id);
        return response()->json(['attend' => $attendinfo]);
    }
    //ge month record
    public function attendanceMonthRecord(Request $request){      
            $monthrecord= Attendance::with('userinfoatt')->where('user_id',$request->id)->where('month',$request->month)->where('year',$request->year)->get();
        return view('admin.attendance.employeerecord',compact('monthrecord'));
    }
    public function recordReport(Request $request){
        $attendance = Attendance::find($request->id);
        $attendance->mark=$request->status;
        $attendance->save();
        return redirect()->back();
    }

    public function attendanceReport($date = ''){
        if(empty($date)){
            $date = now()->toDateString();
        }
        $attinfo= "";
        // $attendance = Attendance::with('userinfo')->get();
        $first_date = date('Y-m-d',strtotime('first day of this month'));
        $last_date = date('Y-m-d',strtotime('last day of this month'));
        $first_date = '2022-08-01';
        $last_date = '2022-08-31';
        $attendance = User::with(['attendence' => function($query)use($first_date,$last_date){
            $query->whereBetween('date', [$first_date,$last_date]);
        }])->where('status', 1)->orderBy('users.first_name')->get();
        // $month = (new DateTime($date))->format('t');
        $month = 31;
        return view('admin.attendance.attendence_report',compact('attendance','month'));
    }

}
