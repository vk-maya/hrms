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
use App\Models\Leave\Leave;
use App\Models\WorkFromHome;

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
        $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', ['form_params' => ['date' => $date]]);
        $response = json_decode($response->getBody()->getContents());

        foreach ($response->data as $key) {
            $user = User::where('employeeID', $key->Empcode)->first();
            // $leave = Leave::where('user_id',$user->id)

            if (!empty($user)) {
                $leaveCount = '';
                if ($key->Status != 'P') {
                    $leaveCount = Leave::where('user_id', $user->id)->where('status',0)->where(function ($query) use ($date) {
                        $query->where("form", ">=", $date)->where('to','<=', $date);
                    })->count();
                    $wfhCount = WorkFromHome::where('user_id', $user->id)->where('status',0)->where(function ($query) use ($date) {
                        $query->where("from", ">=", $date)->where('to','<=', $date);
                    })->count();
                    if ($leaveCount == 0){
                        $leaveCount="L";
                    }elseif($wfhCount ==0){
                        $leaveCount="WFH";
                    }else{
                        $leaveCount="A";
                    }
                }

                $attend = Attendance::where('user_id', $user->id)->where('date', $date)->first();
                if (!empty($attend)) {
                    $attend->in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                    $attend->out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                    if ($attend->in_time != '00:00' && $attend->out_time != '00:00') {
                        $out_time = Carbon::parse($attend->out_time)->format('H:i A');
                        $work_time = Carbon::parse($attend->in_time)->diff(\Carbon\Carbon::parse($attend->out_time))->format('%H:%I:%S');
                        $attend->work_time = $work_time;
                    } else {
                        $attend->work_time = '00:00';
                    }
                    $attend->attendance = $key->Status;
                    $attend->status = ($key->Status == 'P') ? 1 : 0;
                    $attend->passdate = ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null;
                    $attend->mark = ($key->Status == 'P') ? 'P' : $leaveCount;
                    $attend->save();
                    $monthLeave= monthleave::where('user_id',$user->id)->where('status',1)->first();
                    if ($attend->mark =="P"|| $attend->mark =="WFH" ){
                        $monthLeave->working_day=$monthLeave->working_day+1;
                    }elseif($attend->mark =="A"){
                        $monthLeave->other=$monthLeave->other+1;
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

                    Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $work_time, 'date' => date('Y-m-d', strtotime($date)), 'day' => date('d', strtotime($date)), 'month' => date('m', strtotime($date)), 'year' => date('Y', strtotime($date)), 'attendance' => $key->Status, 'status' => ($key->Status == 'P') ? 1 : 0, 'mark' => ($key->Status == 'P') ? 'P' : $leaveCount,'passdate' => ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null]);
                    $totalWorkingDay= Attendance::where('user_id',$user->id)->where('date',$date)->select('mark')->first();
                    $monthLeave= monthleave::where('user_id',$user->id)->where('status',1)->first();
                    if ($totalWorkingDay->mark =="P"|| $totalWorkingDay->mark =="WFH" ) {
                        $monthLeave->working_day=$monthLeave->working_day+1;
                    }elseif($totalWorkingDay->mark =="A"){
                        $monthLeave->other=$monthLeave->other+1;
                    }
                    $monthLeave->save();
                }
            }
        }
        if(date('H:i') <= '09:02'){
            $wfh_users = User::where(['workplace' => 'wfh', 'status' => 1])->get();
            if (count($wfh_users)) {
                foreach ($wfh_users as $key => $value) {
                    Attendance::create([
                        'user_id' => $value->id,
                        'in_time' => '00:00',
                        'out_time' => '00:00',
                        'work_time' => '00:00',
                        'date' => date('Y-m-d', strtotime($date)),
                        'day' => date('d', strtotime($date)),
                        'month' => date('m', strtotime($date)),
                        'year' => date('Y', strtotime($date)),
                        'attendance' => 'A',
                        'status' => 0,
                        'mark' => 'WFH',
                        'passdate' => null
                    ]);
                }
            }
        }
        return $this->info('Attendence Update Successfully');
    }
}
