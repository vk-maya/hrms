<?php

namespace App\Console\Commands;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Attendance;
use App\Models\monthleave;
use App\Models\Admin\Session;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\Admin\LeaveMonthAttandance;

class Attendence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attend:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attendence Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $client = new Client();
        $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', [
            'form_params' => [
                'date' => $date,
        ]]);
        $response = json_decode($response->getBody()->getContents());

        foreach ($response->data as $key) {
            $user = User::where('employeeID', $key->Empcode)->first();

            if (!empty($user)) {
                $attend = Attendance::where('user_id', $user->machineID)->where('date', $date)->first();

                if (!empty($attend)) {
                    $attend->in_time = $key->INTime=='--:--'?'00:00':$key->INTime;
                    $attend->out_time = $key->OUTTime=='--:--'?'00:00':$key->OUTTime;
                    $attend->work_time = $key->WorkTime;
                    $attend->attendance = $key->Status;
                    $attend->status = $key->Status=='P'?1:0;
                    $attend->save();
                }else{
                    Attendance::create([
                        'user_id' => $user->machineID,
                        'in_time' => $key->INTime=='--:--'?'00:00':$key->INTime,
                        'out_time' => $key->OUTTime=='--:--'?'00:00':$key->OUTTime,
                        'work_time' => $key->WorkTime,
                        'date' => date('Y-m-d'),
                        'day' => date('d'),
                        'month' => date('m'),
                        'year' => date('Y'),
                        'attendance' => $key->Status,
                        'status' => $key->Status=='P'?1:0,
                    ]);
                }
            }
        //leave vs attandance function 

        $date = now();
        $date = date('Y-m-d', strtotime($date));
        $id = Attendance::where('user_id', $user->machineID)->where('status',1)->where('date',$date)->latest()->first();        
        $id= $id->user_id;
        $month = date('m', strtotime($date));
            $data = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                $query->where("from", "<=",  $date)->where("to", ">=", $date);
            })->count();
            $leavedata = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                $query->where("from", "<=",  $date)->where("to", ">=", $date);
            })->first();
        $leavetype = settingleave::find($leavedata->type_id);
        if ($data > 0) {
            $monthattedance = LeaveMonthAttandance::where('status', 1)->where('user_id', $id)->where('month', $month)->first();
            $update = date('Y-m-d', strtotime($monthattedance->updated_at));
            if ($update != $date) {
                if ($monthattedance != null) {
                    $monthattedance = LeaveMonthAttandance::where('user_id', $id)->where('status', 1)->where('month', $month)->first();
                        if ($leavetype->type == "Annual") {
                            $monthattedance->anual = $monthattedance->anual + 1;
                        } elseif ($leavetype->type == "Sick") {
                            $monthattedance->sick = $monthattedance->sick + 1;
                        } else {
                            $monthattedance->other = $monthattedance->other + 1;
                        }
                    $monthattedance->date= Carbon::now()->startOfMonth()->toDateString('Y-m-d');
                    $monthattedance->save();
                } else {
                    $monthattedance = new LeaveMonthAttandance();
                    $monthattedance->user_id = $id;
                    $monthattedance->month = $month;
                        if ($leavetype->type == "Annual") {
                            $monthattedance->anual = 1;
                        } elseif ($leavetype->type == "Sick") {
                            $monthattedance->sick = 1;
                        } else {
                            $monthattedance->other = 1;
                        }
                    $monthattedance->date= Carbon::now()->startOfMonth()->toDateString('Y-m-d');
                    $monthattedance->save();
                }
            }
        }
    }
        $this->info('Attendence Update Successfully');
    }


    public function handlem($id){
        // dd($id);
      

        $today = \Carbon\Carbon::now();
        $fristMonthofDay =  Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $lastMonthofDay = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $leaves = Leaverecord::where('user_id', $id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
        })->get();
      
       

        $leavet = settingleave::where('status', 1)->get();
        foreach ($leaves as $leave) {
            $leavetype = settingleave::find($leave->type_id);
            $monthleave = monthleave::where('user_id', $leave->user_id)->where('status', 1)->where('to', $lastMonthofDay)->first();
            // dd($monthleave->toArray(),$leave->user_id);

            if ($leavetype->type == "Annual") {
                if ($monthleave != null) {
                    $monthleave->apprAnual = $monthleave->apprAnual + $leave->day;
                } else {
                    $monthleave->apprAnual = $leave->day;
                }
            } elseif ($leavetype->type == "Sick") {
                if ($monthleave != null) {
                    $monthleave->apprSick = $monthleave->apprSick + $leave->day;
                } else {
                    $monthleave->apprSick = $leave->day;
                }
            } else {
                if ($monthleave != null) {
                    $monthleave->other = $monthleave->other + $leave->day;
                } else {
                    $monthleave->other = $leave->day;
                }
            }
            $monthleave->status = 1;
            $monthleave->save();
        }
          //Attendance Vs Month Leave Table 
        $salarymonthLastDate=Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $dd = date('d', strtotime($salarymonthLastDate));
        $monthFingerApproved= LeaveMonthAttandance::where('user_id',$id)->where('date',$firstDayofPreviousMonth)->first();
        $monthLeaveCalculate=monthleave::where('status',1)->where('user_id',$id)->where('to',$salarymonthLastDate)->first();
        //month Vs Attendance Calculate day
        if (isset($monthFingerApproved->anual)&&$monthFingerApproved->anual != null) {
            # code...
            $anual=$monthLeaveCalculate->apprAnual-$monthFingerApproved->anual;
            $monthLeaveCalculate->apprAnual=$anual;
        }
        if (isset($monthFingerApproved->anual)&&$monthFingerApproved->sick != null) {
            # code...
            $sick=$monthLeaveCalculate->apprSick-$monthFingerApproved->sick;
            $monthLeaveCalculate->apprSick=$sick;
        }
        if (isset($monthFingerApproved->anual)&&$monthFingerApproved->other) {
            # code...
            $other=$monthLeaveCalculate->other-$monthFingerApproved->other;
            $monthLeaveCalculate->other=$other;
        }
        $monthLeaveCalculate->save();   
        // dd($monthLeaveCalculate);
        //monthLeave In status 0 Update Function
        $monthleave = monthleave::where('user_id', $id)->where('status', 1)->where('to', $lastMonthofDay)->first();
        $monthleave->status = 0;
        $monthleave->save();
        //get a new entery month in user 
        $monthdata = $monthleave;
        $session = Session::where('status', 1)->first();
        $fristMonthofDay =  Carbon::now()->startOfMonth()->toDateString();
        $lastMonthofDay = Carbon::now()->endOfMonth()->toDateString();
        $monthleave = new monthleave();
        $monthleave->user_id = $id;
        $monthleave->useryear_id = $session->id;
        $monthleave->from = $fristMonthofDay;
        $monthleave->to = $lastMonthofDay;
        $anual = $monthdata->anualLeave - $monthdata->apprAnual;
        if ($anual > 0) {
            foreach ($leavet as $leave) {
                if ($leave->type == "Annual") {
                    $day = $leave->day / 12;
                    $monthleave->anualLeave = $anual + $day;
                }
            }
        } else {
            foreach ($leavet as $leave) {
                if ($leave->type == "Annual") {
                    $day = $leave->day / 12;
                    $monthleave->anualLeave = $day;
                }
            }
        }
        $sick = $monthdata->sickLeave - $monthdata->apprSick; //due day sick
        if ($sick > 0) {
            foreach ($leavet as $leave) {
                if ($leave->type == "Sick") {
                    $day = $leave->day / 12;
                    $monthleave->sickLeave = $sick + $day;
                }
            }
        } else {
            foreach ($leavet as $leave) {
                if ($leave->type == "Sick") {
                    $day = $leave->day / 12;
                    $monthleave->sickLeave = $day;
                }
            }
        }
        $monthleave->status = 1;
        $monthleave->save();
        
    }
}
