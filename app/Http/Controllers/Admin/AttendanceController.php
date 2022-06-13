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
        $attendance = Attendance::with('userinfo')->get();
        $attendance = User::with(['attendence' => function($query){
            $query->where('month', 6)->where('year', 2022);
        }])->where('status', 1)->get();
        $month = (new DateTime($date))->format('t');     
        return view('admin.attendance.attendance',compact('attendance','month'));
    }
    public function attinfo($id){
        $attendinfo = Attendance::find($id);
        $tt = Carbon::create($attendinfo->in_time)->diff($attendinfo->out_time);
        $attendinfo->working_time = Carbon::createFromTime($tt->h, $tt->i, $tt->s)->format('h:i:s');
        return response()->json(['attend' => $attendinfo]);

    }
    
}
