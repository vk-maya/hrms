<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        }])->where('status', 1)->orderBy('first_name')->get();
        // dd($attendance->toArray());
        $month = (new DateTime($date))->format('t');
        return view('admin.attendance.attendance',compact('attendance','month'));
    }
    public function attinfo($id){
        $attendinfo = Attendance::find($id);
        // dd($attendinfo);
        // $work_time =Carbon::parse($attendinfo->in_time)->diff(\Carbon\Carbon::parse($attendinfo->out_time))->format('%H:%I:%S');
        // $attendinfo->working_time =Carbon::parse($work_time."- 1 hour")->toTimeString();
        return response()->json(['attend' => $attendinfo]);

    }

}
