<?php

namespace App\Http\Controllers;

use App\Models\Admin\Session;
use App\Models\Admin\UserleaveYear;
use App\Models\Leave\settingleave;
use App\Models\monthleave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $employees = User::where('status', 1)->get();
        $session = Session::where('status', 1)->latest()->first();
        $allleave = settingleave::where('status', 1)->get();
        foreach ($employees as $key => $employee) {
            $user_yearleave = UserleaveYear::where('session_id', $session->id)->where('user_id', $employee->id)->first();

            $jd = $employee->joiningDate;
            if ($jd <= $session->from){
                $jd = $session->from;
            }

            $diffr = round(Carbon::parse($jd)->floatDiffInMonths($session->to));

            foreach ($allleave as $key => $value){
                if ($value->type == "PL"){
                    $anual = $value->day / 12;
                }elseif ($value->type == "Sick"){
                    $sickl = $value->day / 12;
                }
            }

            $diffr = round(Carbon::parse($jd)->floatDiffInMonths(Carbon::now()));
            $month_date = Carbon::now()->subMonth($diffr)->format('Y-m-d');

            if ($jd >= $session->from){
                if ($jd < $month_date){
                    $jd = date('Y-m', strtotime($jd));
                    $jd = $jd . "-01";
                }else{
                    $jd = Carbon::parse($jd)->addMonths();
                    $jd = date('Y-m', strtotime($jd));
                    $jd = $jd . "-01";
                }
            }else{
                $jd = $session->from;
            }
            $annualleave = 0;
            $sickleave = 0;
            for ($i=1; $i <= $diffr; $i++) {
                $annualleave = $annualleave + $anual;
                $sickleave = $sickleave + $sickl;
                $data = new monthleave();
                $data->user_id = $employee->id;
                $data->useryear_id = $user_yearleave->id;
                // $data->user_id = 1;
                // $data->useryear_id = 1;

                $data->from = Carbon::parse($jd)->format('Y-m').'-01';
                $data->to = Carbon::parse($jd)->format('Y-m').'-'.Carbon::parse($jd)->daysInMonth;
                $data->anualLeave = $annualleave;
                $data->sickLeave = $sickleave;
                if (Carbon::parse($jd)->format('m') == Carbon::now()->format('m')) {
                    $data->status = 1;
                }else{
                    $data->status = 0;
                }
                $data->save();
                $jd = Carbon::parse($jd)->addMonth();
            }
        }
    }
}
