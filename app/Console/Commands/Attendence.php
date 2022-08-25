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
        $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', ['form_params' => ['date' => $date,]]);
        $response = json_decode($response->getBody()
            ->getContents());

        foreach ($response->data as $key) {
            $user = User::where('employeeID', $key->Empcode)->first();
            if (!empty($user)) {
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
                    $attend->status = ($key->Status == 'P') ? 1 : 0;
                    $attend->passdate = ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null;
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
                    Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $work_time, 'date' => date('Y-m-d', strtotime($date)), 'day' => date('d', strtotime($date)), 'month' => date('m', strtotime($date)), 'year' => date('Y', strtotime($date)), 'attendance' => $key->Status, 'status' => ($key->Status == 'P') ? 1 : 0, 'passdate' => ($key->Status == 'P') ? date('Y-m-d', strtotime($date)) : null]);
                }
                //leave vs attandance function
                $date = date('Y-m-d', strtotime($date));
                $id = Attendance::where('user_id', $user->id)->where('status', 1)->where('date', $date)->latest()->first();
                if (isset($id)) {
                    $id = $id->user_id;
                    $month = date('m', strtotime($date));
                    $data = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                        $query->where("from", "<=", $date)->where("to", ">=", $date); })->count();
                    $leavedata = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) { $query->where("from", "<=", $date)->where("to", ">=", $date); })->first();
                    if (isset($leavedata)){
                        $leavetype = settingleave::find($leavedata->type_id);
                        if ($data > 0) {
                            $monthattedance = LeaveMonthAttandance::where('status', 1)->where('user_id', $id)->where('date', $date)->first();
                            if ($monthattedance == null) {
                                $monthattedance = LeaveMonthAttandance::where('user_id', $id)->where('status', 1)->where('month', $month)->first();
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
        $this->info('Attendence Update Successfully');
    }
}
