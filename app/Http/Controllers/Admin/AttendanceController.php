<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    //
    public function attendance($date = ''){
        if(empty($date)){
            $date = now()->toDateString();
        }
        $attendance = Attendance::with('userinfo')->get();
        $attendance = User::with(['attendence' => function($query){
            $query->where('month', 6)->where('year', 2022);
        }])->where('status', 1)->get();
        $month = (new DateTime($date))->format('t');
        // dd($daysInAugust2020);
        // dd($attendance->toarray());
        return view('admin.attendance.attendance',compact('attendance','month'));
    }
}
