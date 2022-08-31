<?php

namespace App\Console\Commands;

use App\Models\Admin\LeaveMonthAttandance;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave\Leave;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\User;
use App\Models\WorkFromHome;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class MonthlyAttend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:attend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Attendence';

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
        $first_date = date('Y-m-').'01';
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
                        if (!empty($attend)) {
                            $attend->in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                            $attend->out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                            if ($attend->in_time != '00:00' && $attend->out_time != '00:00') {
                                $out_time = Carbon::parse($attend->out_time)->format('H:i A');
                                $work_time = Carbon::parse($attend->in_time)->diff(\Carbon\Carbon::parse($attend->out_time))->format('%H:%I:%S');
                                $work_time = Carbon::parse($work_time . "- 1 hour")->toTimeString();
                                $attend->work_time = $work_time;
                            } else {
                                $attend->work_time = '00:00';
                            }
                            $attend->attendance = $key->Status;
                            $attend->status = $key->Status == 'P' ? 1 : 0;
                            $attend->passdate = ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null;
                            $attend->mark = ($key->Status == 'P') ? 'P' : $leaveCount;
                            $attend->save();
                        } else {
                            $in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                            $out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                            if ($in_time != '00:00' && $out_time != '00:00') {
                                $work_time = Carbon::parse($in_time)->diff(\Carbon\Carbon::parse($out_time))->format('%H:%I:%S');
                                $work_time = Carbon::parse($work_time . "- 1 hour")->toTimeString();
                            } else {
                                $work_time = '00:00';
                            }
                            Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $work_time, 'date' => date('Y-m-d', strtotime($date)), 'day' => date('d', strtotime($date)), 'month' => date('m', strtotime($date)), 'year' => date('Y', strtotime($date)), 'attendance' => $key->Status, 'status' => $key->Status == 'P' ? 1 : 0, 'mark' => ($key->Status == 'P') ? 'P' : $leaveCount,'passdate' => ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null]);
                        }
                        //leave vs attandance function
                        $date = date('Y-m-d', strtotime($date));
                        $id = Attendance::where('user_id', $user->id)->where('status', 1)->where('date', $date)->latest()->first();
                        if (isset($id)) {

                            $id = $id->user_id;
                            $month = date('m', strtotime($date));
                            $data = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                                $query->where("from", "<=", $date)->where("to", ">=", $date);
                            })->count();
                            $leavedata = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                                $query->where("from", "<=", $date)->where("to", ">=", $date);
                            })->first();

                            if (isset($leavedata)) {
                                $leavetype = settingleave::find($leavedata->type_id);
                                if ($data > 0) {
                                    $monthattedance = LeaveMonthAttandance::where('status', 1)->where('user_id', $id)->where('date', $date)->first();
                                    if ($monthattedance == null) {
                                        $monthattedance = LeaveMonthAttandance::where('user_id', $id)->where('status', 1)
                                            ->where('month', $month)->first();
                                        $monthattedance = new LeaveMonthAttandance();
                                        $monthattedance->user_id = $id;
                                        $monthattedance->type_id = $leavedata->type_id;
                                        $monthattedance->date = $date;
                                        $monthattedance->month = $month;
                                        if ($leavetype->type == "PL") {
                                            $monthattedance->anual = 1;
                                        } elseif ($leavetype->type == "Sick") {
                                            $monthattedance->sick = 1;
                                        } else {
                                            $monthattedance->other = 1;
                                        }
                                        $monthattedance->save();
                                    }
                                }
                            }
                        }
                    }
                }
                $this->info($new_date.' - Attendence Update Successfully');
            }
            $new_date = date('Y-m-d', strtotime($new_date.'+1 day'));
        }
    }
}
