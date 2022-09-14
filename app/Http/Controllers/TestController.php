<?php

namespace App\Http\Controllers;

use App\Models\Admin\Session;
use App\Models\Admin\UserleaveYear;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave\Leave;
use App\Models\Leave\settingleave;
use App\Models\monthleave;
use App\Models\User;
use App\Models\WorkFromHome;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        // $employees = User::where('status', 1)->get();
        // $session = Session::where('status', 1)->latest()->first();
        // $allleave = settingleave::where('status', 1)->get();
        // foreach ($employees as $key => $employee) {
        //     $user_yearleave = UserleaveYear::where('session_id', $session->id)->where('user_id', $employee->id)->first();

        //     $jd = $employee->joiningDate;
        //     if ($jd <= $session->from){
        //         $jd = $session->from;
        //     }

        //     $diffr = round(Carbon::parse($jd)->floatDiffInMonths($session->to));

        //     foreach ($allleave as $key => $value){
        //         if ($value->type == "PL"){
        //             $anual = $value->day / 12;
        //         }elseif ($value->type == "Sick"){
        //             $sickl = $value->day / 12;
        //         }
        //     }

        //     $diffr = round(Carbon::parse($jd)->floatDiffInMonths(Carbon::now()))+1;
        //     $month_date = Carbon::now()->subMonth($diffr)->format('Y-m-d');

        //     if ($jd >= $session->from){
        //         if ($jd < $month_date){
        //             $jd = date('Y-m', strtotime($jd));
        //             $jd = $jd . "-01";
        //         }else if(date('d', strtotime($jd)) > 15){
        //             $jd = Carbon::parse($jd)->addMonth(1)->format('Y-m-01');
        //         }
        //     }else{
        //         $jd = $session->from;
        //     }

        //     $diffr = round(Carbon::parse($jd)->floatDiffInMonths(Carbon::now()))+1;
        //     $annualleave = 0;
        //     $sickleave = 0;
        //     for ($i=1; $i <= $diffr; $i++) {
        //         $annualleave = $annualleave + $anual;
        //         $sickleave = $sickleave + $sickl;
        //         $data = new monthleave();
        //         $data->user_id = $employee->id;
        //         $data->useryear_id = $user_yearleave->id;
        //         // $data->user_id = 1;
        //         // $data->useryear_id = 1;

        //         $data->from = Carbon::parse($jd)->format('Y-m').'-01';
        //         $data->to = Carbon::parse($jd)->format('Y-m').'-'.Carbon::parse($jd)->daysInMonth;
        //         $data->anualLeave = $annualleave;
        //         $data->carry_pl_leave = $anual;
        //         $data->sickLeave = $sickleave;
        //         $data->carry_sick_leave = $sickl;
        //         if (Carbon::parse($jd)->format('m') == Carbon::now()->format('m')) {
        //             $data->status = 1;
        //         }else{
        //             $data->status = 0;
        //         }
        //         $data->save();
        //         $jd = Carbon::parse($jd)->addMonth();
        //     }
        // }

        $first_date = date('Y-m-').'06';
        $new_date = $first_date;

        for ($i=1; $new_date <= date('Y-m-d'); $i++) {
            $date = date('Y-m-d', strtotime($new_date));
            $sunday = date('w', strtotime($new_date));
            $first_saturday = date('Y-m-d', strtotime('first saturday of '.date('Y-m', strtotime($new_date))));
            $third_saturday = date('Y-m-d', strtotime('third saturday of '.date('Y-m', strtotime($new_date))));
            $holiday = Holiday::where('date', date('Y-m-d', strtotime($date)))->where('status', 1)->first();

            if ($sunday && $first_saturday != $date && $third_saturday != $date && !$holiday) {
                $client = new Client();
                $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', ['form_params' => ['date' => $date]]);
                $response = json_decode($response->getBody()
                    ->getContents());

                foreach ($response->data as $key) {
                    $user = User::where('employeeID', $key->Empcode)->first();
                    if (!empty($user)) {
                        $leaveCount = '';
                        if ($key->Status != 'P') {
                            $leaveCount = Leave::where('user_id', $user->id)->where('status',1)->where(function ($query) use ($date) {
                                $query->where("form", ">=", $date)->where('to','<=', $date);
                            })->count();
                            $wfhCount = WorkFromHome::where('user_id', $user->id)->where('status',1)->where(function ($query) use ($date) {
                                $query->where("from", ">=", $date)->where('to','<=', $date);
                            })->count();

                            if ($leaveCount>0) {
                                $leaveCount="L";
                            }elseif($wfhCount>0){
                                $leaveCount="WFH";
                            }else{
                                $leaveCount="A";
                            }
                        }
                        $attend = Attendance::where('user_id', $user->id)->where('date', $date)->first();
                        $work_time = Carbon::parse($attend->in_time)->diff(\Carbon\Carbon::parse($attend->out_time))->format('%H:%I:%S');
                        if (!empty($attend)) {
                            $attend->in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                            $attend->out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                            if ($attend->in_time != '00:00' && $attend->out_time != '00:00') {
                                $out_time = Carbon::parse($attend->out_time)->format('H:i');
                                $work_time = Carbon::parse($attend->in_time)->diff(\Carbon\Carbon::parse($attend->out_time))->format('%H:%I:%S');
                                $attend->work_time = $work_time;
                            } else {
                                $attend->work_time = '00:00';
                            }
                            $attend->attendance = $key->Status;
                            $attend->status = $key->Status == 'P' ? 1 : 0;
                            $attend->passdate = ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null;
                            if ($work_time < Carbon::parse("06:00:00")->format('H:i:s') && $work_time >= Carbon::parse("06:00:00")->format('H:i:s')) {
                                $attend->mark = ($key->Status == 'P') ? 'HDO' : 'HDO';
                            }elseif($work_time < Carbon::parse("06:00:00")->format('H:i:s')){
                                $attend->mark = ($key->Status == 'P') ? 'A' : 'A';
                            }else{
                                $attend->mark = ($key->Status == 'P') ? 'P' : $leaveCount;
                            }
                            $attend->save();
                        $monthLeave= monthleave::where('user_id',$user->id)->where('status',1)->first();
                            if ($attend->mark =="P"|| $attend->mark =="WFH" ){
                                $monthLeave->working_day=$monthLeave->working_day+1;
                            }elseif($attend->mark =="A"){
                                $monthLeave->other=$monthLeave->other+1;
                            }elseif($attend->mark=="HDO"){
                                $monthLeave->working_day=$monthLeave->working_day+0.5;
                                $monthLeave->other=$monthLeave->other+0.5;
                            }
                        $monthLeave->save();
                        } else {
                            $in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                            $out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                            if ($in_time != '00:00' && $out_time != '00:00') {
                                $work_time = Carbon::parse($in_time)->diff(\Carbon\Carbon::parse($out_time))->format('%H:%I:%S');
                            } else {
                                $work_time = '00:00';
                            }
                            Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $work_time, 'date' => date('Y-m-d', strtotime($date)), 'day' => date('d', strtotime($date)), 'month' => date('m', strtotime($date)), 'year' => date('Y', strtotime($date)), 'attendance' => $key->Status, 'status' => $key->Status == 'P' ? 1 : 0, 'mark' => ($key->Status == 'P') ? 'P' : $leaveCount,'passdate' => ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null]);

                            $totalWorkingDay= Attendance::where('user_id',$user->id)->where('date',$date)->select('mark')->first();
                            $monthLeave= monthleave::where('user_id',$user->id)->where('status',1)->first();
                            if ($totalWorkingDay->mark =="P"|| $totalWorkingDay->mark =="WFH" ) {
                                $monthLeave->working_day=$monthLeave->working_day+1;
                            }else{
                                $monthLeave->other=$monthLeave->other+1;
                            }
                            $monthLeave->save();
                        }
                    }
                }
                print_r($new_date.' - Attendence Update Successfully');
            }
            $new_date = date('Y-m-d', strtotime($new_date.'+1 day'));
        }
    }
}
